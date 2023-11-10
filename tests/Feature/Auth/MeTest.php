<?php

use function Pest\Laravel\{actingAs, assertDatabaseHas, getJson};
use Illuminate\Testing\Fluent\AssertableJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
it('Returns 403 if not authorized', function () {
    // I think it shouldn't matter, but let's create user just in case
    \App\Models\User::factory()->create();
    getJson('/api2/me')->assertUnauthorized();
});

it('Returns valid data', function () {
    $user = \App\Models\User::factory()
        ->hasBlacklists(10)
        ->hasFollows(10)
        ->hasFavoriteFolders(3)
        ->hasFavorites(10)
        ->create(['verified_at'=>now()]);
    actingAs($user)->getJson('/api2/me')->assertOk()
        ->assertJson(fn(AssertableJson $json) => $json->where('id', $user->id)
            ->whereAllType([
                'id' => 'integer',
                'name' => 'string',
                'username' => 'string',
                'created_at' => 'string',
                'photo' => 'array',
                'blacklists' => 'array',
                'follows.work' => 'array',
                'follows.user' => 'array',
                'favorites.works' => 'array',
                'favorites.folders' => 'array',
                'approved_at' => 'string',
                'verified_at' => 'string',
                'email_verified_at' => 'string',
                'unread' => 'integer',
            ])
        );
});
