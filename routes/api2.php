<?php

use Illuminate\Http\Request;
use \App\Http\Middleware\LocaleHeader;

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
    Route::put('profile', \App\Http\Controllers\Api2\ProfileController::class . '@update');
    Route::get('profile', \App\Http\Controllers\Api2\ProfileController::class . '@index');
    Route::get('me', function (Request $request) {
        return $request->user()->load('avatar');
    });
    Route::post('vote', \App\Http\Controllers\Api2\VoteController::class . '@store');
});

Route::middleware(LocaleHeader::class)->get('health', function () {
    return response(__('health.ok'), 200);
});