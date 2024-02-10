<?php

use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseCount, assertDatabaseMissing};
use App\Models\{User, Follow, Work};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Follow user', function () {
    \Illuminate\Support\Facades\Notification::fake();
    [$user1, $user2] = User::factory()->count(2)->create();
    $request = [
        'followable_type' => 'user',
        'followable_id' => $user2->id
    ];
    actingAs($user1)->postJson("api2/follow", $request)->assertCreated();
    Notification::assertSentTo($user2, \App\Notifications\NewFollower::class);
    assertDatabaseHas('follows', [
        ...$request,
        'user_id' => $user1->id
    ]);
    actingAs($user1)->postJson("api2/follow", $request)->assertOk();
    assertDatabaseCount('follows', 1);
});

test('Unfollow', function () {
    [$user1, $user2] = User::factory()->count(2)->create();
    Follow::create([
        'user_id' => $user1->id,
        'followable_type' => 'user',
        'followable_id' => $user2->id
    ]);
    $request = [
        'followable_type' => 'user',
        'followable_id' => $user2->id
    ];
    actingAs($user1)->deleteJson("api2/follow", $request)->assertOk();
    assertDatabaseMissing('follows', [
        ...$request,
        'user_id' => $user1->id
    ]);
    actingAs($user1)->deleteJson("api2/follow", $request)->assertNotFound();
});

test('List follows and followers', function () {
    [$user1, $user2] = User::factory()->count(2)->create();
    $work = Work::factory()->hasTitles(1)->convertedImages()->create();
    Follow::create([
        'user_id' => $user1->id,
        'followable_type' => 'user',
        'followable_id' => $user2->id
    ]);
    Follow::create([
        'user_id' => $user1->id,
        'followable_type' => 'work',
        'followable_id' => $work->id
    ]);
    // Ugly workaround for now
    $expectedWork = $work->load('preview', 'preview.variants', 'titles')->toArray();
    $expectedWork['published_at'] = $expectedWork['published_at']->toISOString();
        actingAs($user1)
        ->getJson("api2/follow")
        ->assertJson([
            'users' => [
                $user2->load('photo', 'photo.variants')->toArray()
            ],
            'works'=> [
                $expectedWork
            ]
        ]);

    actingAs($user2)
        ->getJson("api2/followers")
        ->assertJson([
            $user1->load('photo', 'photo.variants')->toArray()
        ]);
});
