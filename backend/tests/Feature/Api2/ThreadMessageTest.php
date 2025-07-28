<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user2 = User::factory()->create();
});

test('Create message', function () {
    $thread = \App\Models\Thread::factory(['updated_at'=>now()->subDays(2)])->create();
    // We are not a part of this thread
    actingAs($this->user)->postJson("/api2/thread/$thread->id/message", [
        'message' => 'Test message',
    ])->assertForbidden();
    $participant = $thread->participants()->create(['user_id' => $this->user->id]);
    $participant2 = $thread->participants()->create(['user_id' => $this->user2->id, 'approved_at' => now()]);
    // Not approved, so still not a part of it
    actingAs($this->user)->postJson("/api2/thread/$thread->id/message", [
        'message' => 'Test message',
    ])->assertForbidden();
    // Now it should be allowed
    $participant->approved_at = now();
    $participant->save();
    Notification::fake();
    actingAs($this->user)->postJson("/api2/thread/$thread->id/message", [
        'message' => 'Test message',
    ])->assertCreated();
    assertDatabaseHas('messages', ['message' => 'Test message', 'thread_id' => $thread->id]);
    // Posting a new message should change updated_at of a thread
    expect($thread->refresh()->updated_at)->toEqualWithDelta(now(), 2);
    Notification::assertCount(1);
    Notification::assertSentTo($this->user2, \App\Notifications\NewMessage::class);
});

test('Unapproved participants should not receive notifications', function () {
    $thread = \App\Models\Thread::factory()->create();
    
    // Create an approved participant (sender)
    $approvedParticipant = $thread->participants()->create([
        'user_id' => $this->user->id,
        'approved_at' => now()
    ]);
    
    // Create an unapproved participant
    $unapprovedParticipant = $thread->participants()->create([
        'user_id' => $this->user2->id,
        'approved_at' => null
    ]);
    
    Notification::fake();
    
    // Send a message as the approved participant
    actingAs($this->user)->postJson("/api2/thread/$thread->id/message", [
        'message' => 'Test message for unapproved participant',
    ])->assertCreated();
    
    // Verify the message was created
    assertDatabaseHas('messages', [
        'message' => 'Test message for unapproved participant', 
        'thread_id' => $thread->id
    ]);
    
    // Verify no notification was sent to the unapproved participant
    Notification::assertCount(0);
    Notification::assertNotSentTo($this->user2, \App\Notifications\NewMessage::class);
});

test('Delete message', function () {
    $thread = \App\Models\Thread::factory()->has(\App\Models\Participant::factory(['user_id' => $this->user, 'approved_at' => now()]))->create();
    // Can't delete other user messages
    $message = $thread->messages()->create(['message' => 'Test message', 'user_id' => $this->user2->id]);
    actingAs($this->user)->deleteJson("/api2/thread/$thread->id/message/$message->id")->assertForbidden();
    $message->user_id = $this->user->id;
    $message->save();
    actingAs($this->user)->deleteJson("/api2/thread/$thread->id/message/$message->id")->assertOk();
    $message->refresh();
    expect($message->deleted_at)->toEqualWithDelta(now(), 10);
});

test('Update message', function () {
    $thread = \App\Models\Thread::factory()->has(\App\Models\Participant::factory(['user_id' => $this->user, 'approved_at' => now()]))->create();
    // Can't edit other user messages
    $message = $thread->messages()->create(['message' => 'Test message', 'user_id' => $this->user2->id]);
    actingAs($this->user)->putJson("/api2/thread/$thread->id/message/$message->id", [
        'message' => 'Hello :)',
    ])->assertForbidden();
    $message->user_id = $this->user->id;
    $message->created_at = now()->subMinutes(15);
    $message->save();
    // 15 minutes past, can't edit
    actingAs($this->user)->putJson("/api2/thread/$thread->id/message/$message->id", [
        'message' => 'Hello :)',
    ])->assertForbidden();
    $message->created_at = now()->subMinutes(9);
    $message->save();
    // Now we are the owner, and it was less than 10 minutes ago, should work
    actingAs($this->user)->putJson("/api2/thread/$thread->id/message/$message->id", [
        'message' => 'Hello :)',
    ])->assertOk();
    assertDatabaseHas('messages', ['message' => 'Hello :)', 'thread_id' => $thread->id]);
});
