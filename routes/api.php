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
// We don't need auth for this ones
//Route::get('usercsv', 'UserController@csv'); todo: secure this somehow
Route::get('gallery/{language}/{id}', 'GalleryController@show')->middleware('cache:3000,gallery');

Route::get('work/{language}/{id}', 'WorkController@show')->middleware('cache:3000,work');
Route::get('user/{language}/{id}', 'UserController@show')->middleware('cache:3000,user');
Route::get('user', 'UserController@index');

Route::get('comment/{id}', 'CommentController@show')->middleware('cache:3000,comment');

Route::middleware('auth:sanctum')->get('/init', function (Request $request) {
    return $request->user();
});

Route::get('tag/category/{language}', 'TagController@getCategory')->middleware('cache:3000,tags');;

Route::get('vote/{id}', 'VoteController@show');
Route::get('tag/{search}', 'TagController@show');
Route::get('feedback/idea', 'FeedbackController@idea');
Route::get('feedback/feedback', 'FeedbackController@feedback');
Route::get('feedback/complaint', 'FeedbackController@complaint');

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
        'follow' => 'FollowController',
        'blacklist' => 'BlacklistController',
        'feedback' => 'FeedbackController'
    ]);
    Route::post('/image', 'ImageController');
    Route::post('comment', 'CommentController@store');
    Route::put('comment/{comment}', 'CommentController@update');
    Route::delete('comment/{comment}', 'CommentController@destroy');
});


