<?php

namespace Tests\Feature;

use App\Blacklist;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class BlacklistTest extends TestCase
{
    use RefreshDatabase;

    public function testBlacklist()
    {
        $user = User::factory()->create();
        $blacklist_user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/blacklist', [
            'blacklist_user_id' => $blacklist_user->id
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('blacklists', [
            'user_id' => $user->id,
            'blacklist_user_id' => $blacklist_user->id
        ]);
    }


    public function testRemoveFromBlacklist()
    {
        $user = User::factory()->create();
        $blacklist_user = User::factory()->create();
        $blacklist = Blacklist::factory([
            'user_id' => $user->id,
            'blacklist_user_id' => $blacklist_user->id
                              ])->create();
        $response = $this->actingAs($user)->deleteJson('api/blacklist/' . $blacklist->id);
        $response->assertStatus(200);
        $this->assertDatabaseCount('blacklists',0);
    }

    public function testGetBlacklists()
    {
        $user = User::factory()->create();
        Blacklist::factory(['user_id' => $user->id])->count(5)->create();
        $response = $this->actingAs($user)->getJson('api/blacklist');
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('blacklists', 5)
            ->has('users', 6)
            ->has('users.1.photo.url')
        );
    }
}
