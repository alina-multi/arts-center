<?php

use App\Models\Comment;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Notification;
use App\Notifications\{NewReply, NewComment};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('deleting own comment from work', function () {
    $work = Work::factory()->create();
    $user = User::factory()->create();
    $comment = Comment::factory()->create(
        [
            'user_id' => $user->id,
            'commentable_id' => $work->id,
            'commentable_type' => 'work'
        ]
    );
    $this->actingAs($user)->deleteJson('/api2/comment/' . $comment->id)
        ->assertStatus(200);
    $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => now()]);
});

test('deleting someone comment from your work', function () {
    $work = Work::factory()->create();
    $user = User::factory()->create();
    $owner = User::factory()->create();
    $comment = Comment::factory()->create(
        [
            'user_id' => $user->id,
            'commentable_id' => $work->id,
            'commentable_type' => 'work',
        ]
    );
    $work->owners()->attach($owner->id);
    $response = $this->actingAs($owner)->deleteJson('/api2/comment/' . $comment->id);
    $response->assertStatus(200);
    $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => now()]);
    $this->assertDatabaseHas('works', ['comments' => 0]);
});

test('deleting not your comment from not your work', function () {
    $work = Work::factory()->create();
    $user = User::factory()->create();
    $owner = User::factory()->create();
    $me = User::factory()->create();
    $comment = Comment::factory()->create(
        [
            'user_id' => $user->id,
            'commentable_id' => $work->id,
            'commentable_type' => 'work'
        ]
    );
    $work->owners()->attach($owner->id);
    $this->actingAs($me)->deleteJson('/api2/comment/' . $comment->id)->assertStatus(401);
    $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => null]);
});

test('post comment', function () {
    Notification::fake();
    $work = Work::factory()->create();
    $owner = User::factory()->create();
    [$commenter1, $commenter2] = User::factory()->count(2)->create();
    $work->owners()->attach($owner->id);
    $this->actingAs($commenter1)->postJson('api2/comment',
        [
            'commentable_id' => $work->id,
            'commentable_type' => 'work',
            'text' => 'test'
        ]
    )->assertCreated();
    Notification::assertSentTo($owner, NewComment::class);
    $this->assertDatabaseHas('comments', ['commentable_id' => $work->id, 'commentable_type' => 'work', 'text' => 'test']);

    $this->actingAs($commenter2)->postJson('api2/comment',
        [
            'commentable_id' => $work->id,
            'commentable_type' => 'work',
            'comment_id' => 1,
            'text' => 'test'
        ]
    )->assertCreated();
    $this->assertDatabaseHas('comments', ['comment_id' => 1]);
    $this->assertDatabaseHas('works', ['comments' => 2]);
    Notification::assertSentTo($commenter1, NewReply::class);
    Notification::fake();
    // Don't send notification if you comment your own work
    $this->actingAs($owner)->postJson('api2/comment',
        [
            'commentable_id' => $work->id,
            'commentable_type' => 'work',
            'text' => 'test'
        ]
    )->assertCreated();
    $this->assertDatabaseHas('works', ['comments' => 3]);
    Notification::assertNothingSentTo($owner);
});

test('edit comment', function () {
    $work = Work::factory()->create();
    $user = User::factory()->create();
    $comment = Comment::factory()->create(
        [
            'user_id' => $user->id,
            'commentable_id' => $work->id,
            'commentable_type' => 'work'
        ]
    );
    $this->actingAs($user)->putJson('/api2/comment/' . $comment->id, ['text' => 'test'])
        ->assertStatus(200);
    $this->assertDatabaseHas('comments', ['id' => $comment->id, 'text' => 'test']);
});
