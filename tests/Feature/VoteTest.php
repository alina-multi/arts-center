<?php

namespace Tests\Feature;

use App\Vote;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class VoteTest extends TestCase
{
    use RefreshDatabase;

    public function testVoteForWork()
    {
        $response = $this->doVote('work');
    }

    public function testVoteForComment()
    {
        $response = $this->doVote('comment');
    }

    public function testVoteForFeedback()
    {
        $response = $this->doVote('feedback');
    }

    public function testGetVotes()
    {
        // Create 4 votes from 4 users
        for ($x = 0; $x <= 3; $x++) {
            $user = User::factory()->create();
            Vote::factory()->create(['votable_type' => 'work', 'votable_id' => 1, 'user_id' => $user->id, 'vote' => 1]);
        }

        $response = $this->getJson('/api/vote/work_1');
        $response->assertStatus(200)->assertJsonCount(4);
    }

    public function testDoubleVote()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $json = [
            'vote' => 1,
            'votable_type' => 'work',
            'votable_id' => $work->id
        ];
        $this->actingAs($user)->postJson('/api/vote', $json);
        $response2 = $this->actingAs($user)->postJson('/api/vote', $json);
        $response2->assertStatus(422);
        $this->assertDatabaseCount('votes',1);
    }

    public function doVote($type, $vote = 1)
    {
        $class = Relation::getMorphedModel($type);
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $entity = $class::factory()->create();
        $json =  [
            'vote' => $vote,
            'votable_type' => $type,
            'votable_id' => $entity->id
        ];
        $response = $this->actingAs($user)->postJson('/api/vote', $json);
        $response->assertJson(['rating' => 2]);
        $this->assertDatabaseHas(
            'votes',
            [
                'user_id' => $user->id,
                'vote' => $vote,
                'votable_type' => $type,
                'votable_id' => $entity->id
            ]
        );
        // Second vote from different user
        $response = $this->actingAs($user2)->postJson('/api/vote', $json);
        $response->assertStatus(200)->assertJson(['rating' => 3]);
        $this->assertDatabaseHas(
            'votes',
            [
                'user_id' => $user2->id,
                'vote' => $vote,
                'votable_type' => $type,
                'votable_id' => $entity->id
            ]
        );
        $this->assertDatabaseHas(
            $entity->getTable(),
            [
                'rating' => 3,
            ]
        );
        return $response;
    }
}
