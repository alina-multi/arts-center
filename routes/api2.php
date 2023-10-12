<?php

use App\Http\Middleware\LocaleHeader;
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
    WorkImageController
};

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

Route::middleware(['auth:sanctum', LocaleHeader::class])->group(function () {
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
    Route::post('follow', FollowController::class. '@store');
    Route::delete('follow', FollowController::class. '@destroy');
    Route::get('follow', FollowController::class. '@index');
    Route::get('followers', FollowController::class. '@followers');
    Route::post('blacklist', BlacklistController::class. '@store');
    Route::delete('blacklist', BlacklistController::class. '@destroy');
    Route::get('blacklist', BlacklistController::class. '@index');
    Route::get('blacklist', BlacklistController::class. '@index');
    Route::post('favorite', FavoriteController::class. '@store');
    Route::delete('favorite', FavoriteController::class. '@destroy');
    Route::apiResource('favorite-folder', FavoriteFolderController::class);
    Route::post('feedback', FeedbackController::class. '@store');
});

Route::middleware(LocaleHeader::class)->get('health', function () {
    return response(__('health.ok'), 200);
});