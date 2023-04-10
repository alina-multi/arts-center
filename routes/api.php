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
Route::get('gallery/{language}/{id}', 'GalleryController@show');

Route::get('work/{language}/{id}', 'WorkController@show')->middleware('cache:' . 60*60*24);
Route::get('user/{language}/{id}', 'UserController@show');
Route::get('user', 'UserController@index');

Route::get('comment/{id}', 'CommentController@show')->middleware('cache:'. 60*60*24*10); // This one is really easy to invalidate

Route::middleware('auth:sanctum')->get('/init', function (Request $request) {
    return $request->user();
});

Route::get('tag/category/{language}', 'TagController@getCategory')->middleware('cache:'. 60*60*24*10); // Doesn't really change much

Route::get('vote/{id}', 'VoteController@show');
Route::get('tag/{search}', 'TagController@show');
Route::get('feedback/idea/{language}', 'FeedbackController@idea');
/*
 * we don't really need these for now
Route::get('feedback/feedback/{language}', 'FeedbackController@feedback');
Route::get('feedback/complaint/{language}', 'FeedbackController@complaint');
 */
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
// We don't need auth for this ones
Route::get('blog/{blog}', 'BlogController@show');
Route::get('post/{post}', 'PostController@show');

Route::get('health', function () {
    return response('OK 1', 200);
});
