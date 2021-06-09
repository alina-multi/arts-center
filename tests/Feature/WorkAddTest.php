<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class WorkAddTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateWork()
    {
        $user = User::firstWhere('old_id', 1);

        $response = $this->actingAs($user)->get('/api/');

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
