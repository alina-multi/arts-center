<?php

use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseCount, assertDatabaseMissing};
use App\Models\{Work, User};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Complain about work', function () {
    $user = User::factory()->create();
    $work = Work::factory()->create();
    // Required fields
    actingAs($user)->postJson('/api2/feedback', [])->assertInvalid(['language', 'title', 'body', 'type']);
    // Wrong type, body and title required because type is wrong
    actingAs($user)->postJson('/api2/feedback', [
        'language' => 'en',
        'type' => 'wrong',
        'feedbackable_type' => 'work',
        'feedbackable_id' => $work->id,
    ])->assertInvalid([
        'type', 'title',  'body'
    ]);

    // Now only category should be missing
    actingAs($user)->postJson('/api2/feedback', [
        'language' => 'en',
        'type' => 'complaint',
        'feedbackable_type' => 'work',
        'feedbackable_id' => $work->id,
    ])->assertInvalid([
        'category'
    ]);

    actingAs($user)->postJson('/api2/feedback', [
        'language' => 'en',
        'type' => 'complaint',
        'category'=> 'porn',
        'feedbackable_type' => 'work',
        'feedbackable_id' => $work->id,
    ])->assertCreated();
    assertDatabaseCount('feedback', 1);
});
