<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $this->postJson('/auth/login', [
        'email' => $user->email,
        'password' => 'paSSword1',
    ])->assertNoContent();

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->postJson('/auth/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertInvalid('email');

    $this->assertGuest();
});
