<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/auth/register', [
            'username' => 'test-user',
            'email' => 'test@example.com',
            'password' => 'paSSword1',
            'password_confirmation' => 'paSSword1',
        ]);

        $this->assertAuthenticated();
        $response->assertNoContent();
    }
}
