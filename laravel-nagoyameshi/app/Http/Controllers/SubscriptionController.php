<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Sale;
use App\Models\Subscription as UserSubscription;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Subscription as StripeSubscription;

class SubscriptionController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();

        $stripeCustomer = $user->createOrGetStripeCustomer();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = \Stripe\Checkout\Session::create([
            'customer' => $stripeCustomer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => env('STRIPE.PRICE_ID'),
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('mypage', [], true),
        ]);

        return redirect($checkoutSession->url);
    }
    
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        $subscriptionId = $session->subscription;

        // サブスクリプションの詳細をデータベースに保存
        $user = Auth::user();
        UserSubscription::create([
            'user_id' => $user->id,
            'stripe_id' => $subscriptionId,
            'name' => $user->name,
            'stripe_status' => 'active',
            'stripe_price' => env('STRIPE.PRICE_ID'),
            'quantity' => 1,
        ]);

        $user->update(['paid_membership_flag' => true]);

        Sale::create([
            'user_id' => $user->id,
            'amount' => 300,
        ]);
        
        return redirect()->route('mypage')->with('success', 'サブスクリプションの登録が完了しました。');
    }

    public function changeCard()
    {
        $user = Auth::user();
        $stripeCustomer = $user->createOrGetStripeCustomer();

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'setup',
            'customer' => $stripeCustomer->id,
            'success_url' => route('change.card.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('mypage', [], true),
        ]);

        return redirect($checkout_session->url);
    }

    public function changeCardSuccess(Request $request)
    {
        $user = Auth::user();
        $stripeCustomer = $user->createOrGetStripeCustomer();
    
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
        $setup_intent = \Stripe\SetupIntent::retrieve($checkout_session->setup_intent);

        $payment_method = \Stripe\PaymentMethod::retrieve($setup_intent->payment_method);

        // サブスクリプションの支払い方法を更新
        $subscriptions = $user->subscriptions;
        foreach ($subscriptions as $subscription) {
            if ($subscription->stripe_status !== 'canceled') {
                try {
                    \Stripe\Subscription::update($subscription->stripe_id, [
                        'default_payment_method' => $payment_method->id,
                    ]);
                } catch (\Exception $e) {
                    // エラーハンドリング
                    return back()->withErrors(['error' => 'サブスクリプションの支払い方法の更新に失敗しました。']);
                }
            }
        }

        return redirect()->route('mypage')->with('success', 'カード情報の更新が完了しました。');
    }

    public function cancelSubscription()
    {
        $user = Auth::user();

        Log::info('Cancellation started', ['user_id' => $user->id, 'paid_membership_flag' => $user->paid_membership_flag]);

        $activeSubscriptions = $user->subscriptions()->where('stripe_status', '!=', 'canceled')->get();

        Log::info('Active subscriptions', ['count' => $activeSubscriptions->count()]);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        foreach ($activeSubscriptions as $subscription) {
            try {
                $stripeSubscription = StripeSubscription::retrieve($subscription->stripe_id);
                $stripeSubscription->cancel();

                $subscription->update(['stripe_status' => 'canceled']);
                Log::info('Subscription canceled', ['stripe_id' => $subscription->stripe_id]);
            } catch (\Exception $e) {
                Log::error('Subscription cancellation failed', ['error' => $e->getMessage(), 'stripe_id' => $subscription->stripe_id]);
                return back()->withErrors(['error' => 'サブスクリプションのキャンセルに失敗しました。']);
            }
        }

        // アクティブなサブスクリプションが残っているかチェック
        $remainingActiveSubscriptions = $user->subscriptions()->where('stripe_status', '!=', 'canceled')->count();
        
        if ($remainingActiveSubscriptions == 0) {
            $user->update(['paid_membership_flag' => false]);
            Log::info('All subscriptions canceled, flag updated', ['user_id' => $user->id, 'paid_membership_flag' => false]);
        } else {
            Log::info('Some subscriptions still active', ['user_id' => $user->id, 'active_count' => $remainingActiveSubscriptions]);
        }

        return redirect()->route('mypage')->with('success', 'サブスクリプションをキャンセルしました。');
    }  
}