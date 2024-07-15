<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebController::class, 'index'])->name('top');

require __DIR__.'/auth.php';

Route::resource('stores', StoreController::class)->only(['index', 'show']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(ReviewController::class)->group(function () {
        Route::post('reviews', 'store')->name('reviews.store');
        Route::get('reviews', 'index')->name('reviews.index');
        Route::get('reviews/{review}/edit', 'edit')->name('reviews.edit');
        Route::put('reviews/{review}', 'update')->name('reviews.update');
        Route::delete('reviews/{review}', 'destroy')->name('reviews.destroy');
    });

    Route::post('favorites/{store_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{store_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
    });

    Route::controller(ReservationController::class)->group(function () {
        Route::get('reservations', 'index')->name('reservations.index');
        Route::get('stores/{store_id}/reservations/create', 'create')->name('reservations.create');
        Route::post('stores/{store_id}/reservations', 'store')->name('reservations.store');
        Route::get('reservations/{reservation}', 'show')->name('reservations.show');
        Route::get('reservations/{reservation}/edit', 'edit')->name('reservations.edit');
        Route::put('reservations/{reservation}', 'update')->name('reservations.update');
        Route::delete('reservations/{reservation}', 'destroy')->name('reservations.destroy');
    });

    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('checkout-payment', 'checkout')->name('checkout.session');
        Route::get('checkout/success', 'success')->name('checkout.success');
        Route::get('change-card', 'changeCard')->name('change.card');
        Route::get('change-card/success', 'changeCardSuccess')->name('change.card.success');
        Route::get('cancel-subscription', 'cancelSubscription')->name('cancel.subscription');
    });
}); 

Route::post('/stripe/webhook', [WebhookController::class, 'handleStripeWebhook']);