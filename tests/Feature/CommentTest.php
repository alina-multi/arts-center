<?php

namespace Tests\Feature;

use App\Vote;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                'body' => ['test' => 'json']
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
        $response->dump();
    }
}
