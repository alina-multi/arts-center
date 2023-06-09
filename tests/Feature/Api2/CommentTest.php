<?php

namespace Tests\Feature\Api2;

use App\Models\Comment;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

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
        $this->actingAs($user)->deleteJson('/api2/comment/' . $comment->id)
            ->assertStatus(200);
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => now()]);
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
        $response = $this->actingAs($owner)->deleteJson('/api2/comment/' . $comment->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => now()]);
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
        $this->actingAs($me)->deleteJson('/api2/comment/' . $comment->id)->assertStatus(401);
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'deleted_at' => null]);
    }

    public function testPostComment()
    {
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
    }
}
