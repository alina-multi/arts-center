<?php

namespace Tests\Feature;

use App\Vote;
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

    public function testGetVotes()
    {
        // Create 4 votes from 4 users
        for ($x = 0; $x <= 3; $x++) {
            $user = User::factory()->create();
            Vote::factory()->create(['votable_type'=>'work', 'votable_id'=>1, 'user_id'=>$user->id, 'vote'=>1]);
        }

        $response = $this->getJson('/api/vote/work_1');
        $response->assertStatus(200)->assertJsonCount(4);
    }

    public function doVote($type, $vote = 1)
    {
        $class = Relation::getMorphedModel($type);
        $user = User::factory()->create();
        $entity = $class::factory()->create();
        $response = $this->actingAs($user)->postJson(
            '/api/vote',
            [
                'vote' => $vote,
                'votable_type' => $type,
                'votable_id' => $entity->id
            ]
        );
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
        $this->assertDatabaseHas(
            $entity->getTable(),
            [
                'rating' => 2,
            ]
        );
        return $response;
    }
}
