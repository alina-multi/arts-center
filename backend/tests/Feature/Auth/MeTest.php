<?php

use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\{Message, Participant, Thread, User};
use function Pest\Laravel\{actingAs, assertDatabaseHas, getJson};
use Illuminate\Testing\Fluent\AssertableJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
it('Returns 403 if not authorized', function () {
    // I think it shouldn't matter, but let's create user just in case
    User::factory()->create();
    getJson('/api2/me')->assertUnauthorized();
});

it('Returns valid data', function () {
    $user = User::factory()
        ->hasBlacklists(10)
        ->hasFollows(10)
        ->hasFavoriteFolders(3)
        ->hasFavorites(10)
        ->create(['verified_at' => now()]);
    // Have to do this as a separate step because we need $user
    $thread = Thread::factory()
        ->has(Participant::factory(['approved_at'=>now()])->count(2)
            ->state(new Sequence(['user_id' => $user->id], ['user_id' => 999])))
        ->create();
    
    // Create some unread messages for the user
    $otherUserId = 999;
    Message::factory()->count(3)->create([
        'thread_id' => $thread->id,
        'user_id' => $otherUserId,
        'created_at' => now()
    ]);
    
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
                'unread_messages' => 'integer',
                'role' => 'integer',
                'threads' => 'array',
                // Easy way to check that user=>thread a format works
                'threads.999' => 'integer',
                'intent' => ['string', 'null'],
            ])
            ->where('unread_messages', 3)
        );
});
