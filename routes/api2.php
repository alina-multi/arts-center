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

Route::middleware('auth:sanctum')->get('/init', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('profile/avatar', 'Profile\AvatarController');
    Route::post('profile', 'Profile\IndexController');
    Route::post('user/{language}/{id}', 'UserController@update');
    Route::get('edit/{id}', 'Edit\GetEditController');
    Route::apiResources([
        '/edit/block' => 'Edit\BlockController',
        '/edit/title' => 'Edit\TitleController',
        'work' => 'WorkController',
        'vote' => 'VoteController',
        'tag' => 'TagController',
        'follow' => 'FollowController',
        'blacklist' => 'BlacklistController',
        'feedback' => 'FeedbackController',
        'blog' => 'BlogController',
        'post' => 'PostController'
    ]);
    Route::post('/image', 'ImageController');
    Route::post('comment', 'CommentController@store');
    Route::put('comment/{comment}', 'CommentController@update');
    Route::delete('comment/{comment}', 'CommentController@destroy');
    Route::get('feed/{language}', 'FeedController@index');
});

Route::get('health', function () {
    return response('OK 2', 200);
});
