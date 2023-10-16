<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('new users can register', function () {
    $valid = [
        'username' => 'test-user',
        'email' => 'test@example.com',
        'password' => 'paSSword1',
        'password_confirmation' => 'paSSword1',
    ];
    // Profanity filter
    $this->post('/auth/register', [
        ...$valid,
        'username'=>'fucker'
    ])->assertInvalid('username');

    // Reserved words
    $this->post('/auth/register', [
        ...$valid,
        'username'=>'admin'
    ])->assertInvalid('username');

    // Simple password
    $this->post('/auth/register', [
        ...$valid,
        'password'=>'password'
    ])->assertInvalid('password');

    $this->post('/auth/register', $valid)->assertNoContent();

    $this->assertAuthenticated();
});
