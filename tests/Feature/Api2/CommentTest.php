<?php

use App\Models\Comment;
use App\Models\User;
use App\Models\Work;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('delete own comment from work', function () {
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

test('delete someone comment from your work', function () {
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
});

test('delete not your comment from not your work', function () {
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
    $work = Work::factory()->create();
    $owner = User::factory()->create();
    $me = User::factory()->create();
    $work->owners()->attach($owner->id);
    $this->actingAs($me)->postJson('api2/comment',
                                   [
                                       'commentable_id' => $work->id,
                                       'commentable_type' => 'work',
                                       'text' => 'test'
                                   ]
    );
    $this->assertDatabaseHas('comments', ['commentable_id' => $work->id, 'commentable_type' => 'work', 'text'=> 'test']);
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
