<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MailResetPasswordNotification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/auth/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, MailResetPasswordNotification::class);
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/auth/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, MailResetPasswordNotification::class, function (object $notification) use ($user) {
        $response = $this->post('/auth/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'paSSword1',
            'password_confirmation' => 'paSSword1',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});
