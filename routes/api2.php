<?php

use App\Http\Controllers\Api2\{
    VoteController,
    ProfileController,
    WorkController,
    CommentController,
    MeController,
    FollowController,
    BlacklistController,
    FavoriteController,
    FavoriteFolderController,
    FeedbackController,
    WorkImageController,
    CheckoutController,
    PhotoController
};

use Illuminate\Broadcasting\BroadcastController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('profile', ProfileController::class . '@update');
    Route::get('profile', ProfileController::class . '@index');
    Route::get('me', MeController::class);
    Route::post('vote', VoteController::class . '@store');
    Route::delete('vote', VoteController::class . '@destroy');
    Route::apiResource('work', WorkController::class);
    Route::put('work/{work}/publish', WorkController::class . '@publish');
    Route::delete('work/{work}/draft', WorkController::class . '@draft');
    Route::apiResource('comment', CommentController::class);
    Route::apiResource('work.images', WorkImageController::class);
    Route::post('follow', FollowController::class . '@store');
    Route::delete('follow', FollowController::class . '@destroy');
    Route::get('follow', FollowController::class . '@index');
    Route::get('followers', FollowController::class . '@followers');
    Route::post('blacklist', BlacklistController::class . '@store');
    Route::delete('blacklist', BlacklistController::class . '@destroy');
    Route::get('blacklist', BlacklistController::class . '@index');
    Route::get('blacklist', BlacklistController::class . '@index');
    Route::post('favorite', FavoriteController::class . '@store');
    Route::delete('favorite', FavoriteController::class . '@destroy');
    Route::apiResource('favorite-folder', FavoriteFolderController::class);
    Route::post('feedback', FeedbackController::class . '@store');
    Route::post('photo', PhotoController::class);
    Route::match(
        ['get', 'post'], 'broadcasting',
        [BroadcastController::class, 'authenticate']
    )->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('notifications', [\App\Http\Controllers\Api2\NotificationController::class, 'index']);
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\Api2\NotificationController::class, 'markAllRead']);
});

// These ones are not requited to have auth
Route::post('stripe/webhook', [\Laravel\Cashier\Http\Controllers\WebhookController::class, 'handleWebhook'])->name('cashier.webhook');
Route::get('stripe/payment/{id}', [\Laravel\Cashier\Http\Controllers\PaymentController::class, 'show'])->name('cashier.payment');
Route::apiResource('checkout', CheckoutController::class);

Route::get('health', function () {
    return response(__('health.ok'), 200);
});