<?php

namespace Tests\Feature;

use App\Vote;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\User;
use App\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testGetComments()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();
        $userVoted = User::factory()->create();
        $comment = Comment::factory()->create(
            [
                'user_id' => $user->id,
                'commentable_id' => $work->id,
                'commentable_type' => 'work',
                'body' => ["ops" => [["insert" => "test\n"]]]
            ]
        );
        $vote = Vote::factory()->create(
            [
                'votable_type' => 'comment',
                'votable_id' => $comment->id,
                'user_id' => $userVoted->id,
                'vote' => 1
            ]
        );
        $work->owners()->attach($user->id);
        $response = $this->get('/api/comment/work_' . $work->id);
        $response->assertJson(fn(AssertableJson $json) => $json->has('comments', 1)
            ->has('comments.0.votes', 1)
            ->has('users', 2)
        );
    }

    public function testDeleteOwnCommentFromWork()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();
        $comment = Comment::factory()->create(
            [
                'user_id' => $user->id,
                'commentable_id' => $work->id,
                'commentable_type' => 'work',
                'body' => ['test' => 'json']
            ]
        );
        // Load it so it will cache
        $this->get('/api/comment/work_' . $work->id)->assertJson(fn(AssertableJson $json) =>
        $json->has('comments', 1)
            ->has('users', 1)
        );
        $this->actingAs($user)->deleteJson('/api/comment/' . $comment->id)
            ->assertStatus(200);
        // And now let's check that it's actually deleted and cache is invalidated
        $this->get('/api/comment/work_' . $work->id)->assertJson(fn(AssertableJson $json) =>
        $json->has('comments', 0)
            ->has('users', 0)
        );

    }

    public function testDeleteSomeoneCommentFromYourWork()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $comment = Comment::factory()->create(
            [
                'user_id' => $user->id,
                'commentable_id' => $work->id,
                'commentable_type' => 'work',
                'body' => ['test' => 'json']
            ]
        );
        $work->owners()->attach($owner->id);
        $response = $this->actingAs($owner)->deleteJson('/api/comment/' . $comment->id);
        $response->assertStatus(200);
    }

    public function testDeleteNotYourCommentFromNotYourWork()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $me = User::factory()->create();
        $comment = Comment::factory()->create(
            [
                'user_id' => $user->id,
                'commentable_id' => $work->id,
                'commentable_type' => 'work',
                'body' => ['test' => 'json']
            ]
        );
        $work->owners()->attach($owner->id);
        $response = $this->actingAs($me)->deleteJson('/api/comment/' . $comment->id);
        $response->assertStatus(401);
    }

    public function testPostComment()
    {
        $work = Work::factory()->create();
        $owner = User::factory()->create();
        $me = User::factory()->create();
        $work->owners()->attach($owner->id);
        // Load it so it will cache
        $this->get('/api/comment/work_' . $work->id)->assertJson(fn(AssertableJson $json) =>
        $json->has('comments', 0)
            ->has('users', 0)
        );
        $this->actingAs($me)->postJson('api/comment',
                                       [
                                           'commentable_id' => $work->id,
                                           'commentable_type' => 'work',
                                           'body' => ["ops" => [["insert" => "test\n"]]]
                                       ]
        );
        // And now we can check both that comment added and cache is invalidated
        $this->get('/api/comment/work_' . $work->id)->assertJson(fn(AssertableJson $json) =>
        $json->has('comments', 1)
            ->has('users', 1)
        );
    }
}
