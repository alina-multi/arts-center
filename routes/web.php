<?php

Route::post('auth/login', 'Auth\LoginController@login');
Route::post('auth/register', 'Auth\RegisterController@register');
Route::post('auth/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('auth/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('auth/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('auth/user', function () {
    return Auth::user();
});
Route::get('password/reset/{token}',function () {
   //This is a dummy url that would be actually handled by frontend.
})->name('password.reset');
Route::post('auth/logout', 'Auth\LoginController@logout');


Route::get('/api/mail', function () {
    return (new \App\Notifications\MailResetPasswordNotification())
        ->toMail('dsfbjhsdgfhgdsjfhgsjdg');
});
