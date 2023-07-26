<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/auth/login', [
        'email' => $user->email,
        'password' => 'paSSword1',
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/auth/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
