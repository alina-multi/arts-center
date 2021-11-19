<?php

Route::domain('arts.in.ua')->group(function () {
    Route::get('/artists/{username}/w/{work}/', 'RedirectOldController@work');
    Route::get('/artists/{username}/', 'RedirectOldController@user');
    Route::get('/art/{art}/', 'RedirectOldController@art');
    Route::fallback(function () {
        return redirect('https://arts.center',301);
    });
});

Route::post('auth/login', 'Auth\LoginController@login');
Route::post('auth/register', 'Auth\RegisterController@register');
Route::post('auth/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('auth/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('auth/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('auth/user', function () {
    return Auth::user();
});
//This is a dummy urls that would be actually handled by frontend.
Route::get('password/reset/{token}',function () {})->name('password.reset');
Route::get('login',function () {})->name('login');
Route::get('/',function () {})->name('home');
Route::get('/work/{id}',function () {})->name('work');
// Don't forget to add exceptions here for paths like /name
Route::get('/{user}',function () {})->name('user')->where('user', '!(nova|horizon)');


Route::post('auth/logout', 'Auth\LoginController@logout');


Route::get('/vendor/{file}', function ($file) {
    $filename = public_path('vendor/' . $file);
    $mime=\GuzzleHttp\Psr7\MimeType::fromFilename($filename);
    return response(file_get_contents($filename), 200)->header('Content-Type', $mime);
})->where('file', '.*');;

Route::get('auth/subscription/redirect', 'SubscriptionController@redirect')->middleware('auth');
