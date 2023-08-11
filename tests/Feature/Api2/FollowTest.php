<?php

use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseCount, assertDatabaseMissing};
use App\Models\User;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Follow user', function () {
    list($user1, $user2) = User::factory()->count(2)->create();
    $request = [
        'followable_type' => 'user',
        'followable_id' => $user2->id
    ];
    actingAs($user1)->postJson("api2/follow", $request)->assertCreated();
    assertDatabaseHas('follows', [
        ...$request,
        'user_id' => $user1->id
    ]);
    actingAs($user1)->postJson("api2/follow", $request)->assertOk();
    assertDatabaseCount('follows',1);
});

test('Unfollow', function () {
    list($user1, $user2) = User::factory()->count(2)->create();
    \App\Models\Follow::create([
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
