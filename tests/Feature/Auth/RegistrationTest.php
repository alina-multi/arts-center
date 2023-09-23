<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('new users can register', function () {
    $response = $this->post('/auth/register', [
        'username' => 'test-user',
        'email' => 'test@example.com',
        'password' => 'paSSword1',
        'password_confirmation' => 'paSSword1',
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});
