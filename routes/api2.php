<?php

use Illuminate\Http\Request;

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
    Route::post('profile', \App\Http\Controllers\Api2\ProfileController::class . '@update');
    Route::get('profile', \App\Http\Controllers\Api2\ProfileController::class . '@index');
    Route::get('init', function (Request $request) {
        return $request->user()->load('avatar');
    });
});