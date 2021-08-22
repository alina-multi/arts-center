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

Route::get('gallery/{language}/{id}', 'GalleryController@show');

Route::get('work/{language}/{id}', 'WorkController@show');
Route::get('user/{language}/{id}', 'UserController@show');

Route::get('comment/{id}', 'CommentController@show');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tag/category/{language}', 'TagController@getCategory');


// We don't need auth for this ones
Route::get('works/{work}', 'WorkController@show');
Route::get('vote/{id}', 'VoteController@show');
Route::get('tag/{search}', 'TagController@show');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('profile/avatar', 'Profile\AvatarController');
    Route::post('profile', 'Profile\IndexController');
    Route::post('user/{language}/{id}', 'UserController@update');
    Route::get('edit/{id}', 'Edit\GetEditController');
    Route::apiResources([
        '/edit/block' => 'Edit\BlockController',
        '/edit/title' => 'Edit\TitleController',
        'works' => 'WorkController',
        'vote' => 'VoteController',
        'tag' => 'TagController',
        'subscription' => 'SubscriptionController',
        'blacklist' => 'BlacklistController',
        'feedback' => 'FeedbackController'
    ]);
    Route::post('/image', 'ImageController');
    Route::post('comment', 'CommentController@store');
    Route::put('comment/{comment}', 'CommentController@update');
    Route::delete('comment/{comment}', 'CommentController@destroy');
});


