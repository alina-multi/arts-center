<?php

use App\Http\Middleware\LocaleHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Api2\VoteController;
use App\Http\Controllers\Api2\ProfileController;

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
    Route::get('me', function (Request $request) {
        return $request->user()->load('photo');
    });
    Route::post('vote', VoteController::class . '@store');
    Route::delete('vote', VoteController::class . '@destroy');
    Route::apiResource('draft', \App\Http\Controllers\Api2\DraftController::class, ['only' => ['store', 'show']]);
    Route::apiResource('comment', \App\Http\Controllers\Api2\CommentController::class, ['only' => ['store', 'update', 'destroy']]);
});

Route::middleware(LocaleHeader::class)->get('health', function () {
    return response(__('health.ok'), 200);
});