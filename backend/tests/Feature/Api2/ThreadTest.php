<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user2 = User::factory()->create();
});

test('Create thread', function () {
    $response = actingAs($this->user)->postJson('/api2/thread', [
        'title' => 'New thread',
        'participants' => [$this->user2->id],
    ]);

    $content = $response->assertCreated()->json();

    assertDatabaseHas('threads', ['title' => 'New thread']);

    // User that sent request is added and approved
    assertDatabaseHas('participants', [
        'user_id' => $this->user->id,
        'thread_id' => $content['id'],
        'approved_at' => now()
    ]);
    // User that are listed in participants added but not approved yet
    assertDatabaseHas('participants', [
        'user_id' => $this->user2->id,
        'thread_id' => $content['id'],
        'approved_at' => null
    ]);
});

test('Update thread', function () {
    $thread = \App\Models\Thread::factory()->hasParticipants(1)->create();
    // Only participants can edit the thread
    actingAs($this->user)->putJson("/api2/thread/$thread->id", [
        'title' => 'New thread',
    ])->assertForbidden();

    // Now this should work
    $thread->participants()->create(['user_id' => $this->user->id, 'approved_at' => now()]);
    actingAs($this->user)->putJson("/api2/thread/$thread->id", [
        'title' => 'New thread',
    ])->assertOk();

    assertDatabaseHas('threads', ['title' => 'New thread']);
});

test('No delete route exists', function () {
    $thread = \App\Models\Thread::factory()->create();
    actingAs($this->user)->deleteJson("/api2/thread/$thread->id")->assertMethodNotAllowed();
});

test('Index shows correct threads', function () {
    [$unrelated, $unapproved, $valid] = \App\Models\Thread::factory()->hasMessages(3, ['user_id' => $this->user->id])->count(3)->create();
    $unapproved->participants()->create(['user_id' => $this->user->id]);
    $valid->participants()->create(['user_id' => $this->user->id, 'approved_at' => now()]);
    actingAs($this->user)->getJson("/api2/thread")->assertOk()->assertJsonCount(1)->assertExactJson([
        [
            "id" => $valid->id,
            "title" => $valid->title,
            "type" => $valid->type,
            "created_at" => $valid->created_at,
            "updated_at" => $valid->updated_at,
            "participants" => $valid->participants->toArray(),
            "last_message" => $valid->messages->last()->load('user', 'user.photo')->toArray(),
            "pivot" => [
                "last_read" => null,
                "thread_id" => $valid->id,
                "user_id" => $this->user->id
            ]
        ]
    ]);
});
