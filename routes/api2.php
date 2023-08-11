<?php

use App\Http\Middleware\LocaleHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Api2\{
    VoteController,
    ProfileController,
    DraftController,
    CommentController,
    MeController,
    FollowController
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
    Route::apiResource('draft', DraftController::class);
    Route::put('draft/{draft}/publish', DraftController::class . '@publish');
    Route::delete('draft/{draft}/draft', DraftController::class . '@draft');
    Route::apiResource('comment', CommentController::class);
    Route::post('follow', FollowController::class. '@store');
    Route::delete('follow', FollowController::class. '@destroy');
});

Route::middleware(LocaleHeader::class)->get('health', function () {
    return response(__('health.ok'), 200);
});