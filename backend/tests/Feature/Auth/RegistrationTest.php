<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
use \Illuminate\Support\Facades\Mail;

test('new users can register', function () {
    Mail::fake();
    Event::fake();
    $valid = [
        'username' => 'test_user',
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
});
