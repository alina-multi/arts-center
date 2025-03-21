<?php

use App\Enums\UserIntents;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can update their intent', function () {
    $user = User::factory()->create();
    
    $response = actingAs($user)->putJson('/api2/intent', [
        'intent' => UserIntents::ShowcaseArt->value,
    ]);
    
    $response->assertNoContent();
    
    assertDatabaseHas('users', [
        'id' => $user->id,
        'intent' => UserIntents::ShowcaseArt->value,
    ]);
});

test('user cannot set invalid intent', function () {
    $user = User::factory()->create();
    
    $response = actingAs($user)->putJson('/api2/intent', [
        'intent' => 'invalid_intent',
    ]);
    
    $response->assertStatus(422);
});

test('intent is required', function () {
    $user = User::factory()->create();
    
    $response = actingAs($user)->putJson('/api2/intent', []);
    
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['intent']);
});

test('unauthenticated user cannot update intent', function () {
    $response = putJson('/api2/intent', [
        'intent' => UserIntents::ShowcaseArt->value,
    ]);
    
    $response->assertStatus(401);
});
