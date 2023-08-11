<?php

use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseCount, assertDatabaseMissing};
use App\Models\User;
use App\Models\Blacklist;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Blacklist user', function () {
    list($user1, $user2) = User::factory()->count(2)->create();
    actingAs($user1)->postJson("api2/blacklist", ['user_id' => $user2->id])->assertCreated();
    assertDatabaseHas('blacklists', [
        'blacklist_user_id' => $user2->id,
        'user_id' => $user1->id
    ]);
    actingAs($user1)->postJson("api2/blacklist", ['user_id' => $user2->id])->assertOk();
    assertDatabaseCount('blacklists', 1);
});

test('Remove user from blacklist', function () {
    list($user1, $user2) = User::factory()->count(2)->create();
    Blacklist::create([
        'user_id' => $user1->id,
        'blacklist_user_id' => $user2->id
    ]);
    actingAs($user1)->deleteJson("api2/blacklist", ['user_id' => $user2->id])->assertOk();
    assertDatabaseMissing('blacklists', [
        'user_id' => $user1->id,
        'blacklist_user_id' => $user2->id
    ]);
    actingAs($user1)->deleteJson("api2/blacklist", ['user_id' => $user2->id])->assertNotFound();
});
