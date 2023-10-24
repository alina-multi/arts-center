<?php

use function Pest\Laravel\{postJson, actingAs, assertDatabaseHas, assertDatabaseCount, assertDatabaseMissing};
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Create checkout session for frontend', function () {
    $user = User::factory()->create();
    // user_id should be verified and required fields
    postJson("api2/checkout", [
        'user_id' => $user->id
    ])->assertInvalid(['user_id', 'quantity', 'username', 'type']);
    $user->verified_at = now();
    $user->save();
    postJson("api2/checkout", [
        'user_id' => $user->id,
        'quantity' => 3,
        'username' => $user->username,
        'type' => \App\Enums\TransactionTypes::DONATION
    ])->assertJson(fn(AssertableJson $json) => $json->whereType('clientSecret', 'string'));
});