<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->all();
        $event = $payload['type'];

        if ($event == 'invoice.payment_succeeded') {
            $invoice = $payload['data']['object'];

            // 顧客情報と金額を取得
            $customerId = $invoice['customer'];
            $amount = $invoice['amount_paid'] / 100; // Stripeは最小通貨単位（セント、ペンスなど）で計算

            // ユーザーを取得
            $user = User::where('stripe_id', $customerId)->first();

            // 売上データを保存
            Sale::create([
                'user_id' => $user->id,
                'amount' => $amount,
            ]);
        }

        return response()->json(['status' => 'success'], 200);
    }
}
