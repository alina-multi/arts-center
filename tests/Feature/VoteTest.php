<?php

namespace Tests\Feature;

use App\Jobs\RecountUserRatings;
use App\Tag;
use App\TagTitle;
use App\Vote;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Bus;

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
        $this->assertDatabaseCount('votes', 1);
    }

    public function testVoteWorkTagRating()
    {
        Bus::fake();
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $work = Work::factory()->create();
        $tag = Tag::factory()->create();
        TagTitle::factory(['tag_id' => $tag->id, 'title' => 'test'])->create();
        $work->tags()->attach($tag->id);
        $work->owners()->attach($owner->id);
        $json = [
            'vote' => 1,
            'votable_type' => 'work',
            'votable_id' => $work->id
        ];
        $this->actingAs($user)->postJson('/api/vote', $json);
        Bus::assertDispatched(RecountUserRatings::class);
    }

    public function doVote($type, $vote = 1)
    {
        $class = Relation::getMorphedModel($type);
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $entity = $class::factory()->create();
        $json = [
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

    public function testRecountUserRatings()
    {
        $owner = User::factory()->create();
        $work = Work::factory(['rating'=>5])->create();
        $work2 = Work::factory(['rating'=>3])->create();
        $tag = Tag::factory(['type_id'=>Tag::TYPE_CATEGORY])->create();
        $tag2 = Tag::factory(['type_id'=>Tag::TYPE_CATEGORY])->create();
        $work->category()->attach($tag->id);
        $work->owners()->attach($owner->id);
        $work2->category()->attach($tag->id);
        $work2->category()->attach($tag2->id);
        $work2->owners()->attach($owner->id);
        RecountUserRatings::dispatchSync($owner->id);
        $this->assertDatabaseHas('user_ratings', ['ratable_type' => 'tag', 'ratable_id' => $tag->id, 'rating' => 8]);
        $this->assertDatabaseHas('user_ratings', ['ratable_type' => 'tag', 'ratable_id' => $tag2->id, 'rating' => 3]);
        $this->assertDatabaseHas('user_ratings', ['ratable_type' => 'user', 'ratable_id' => $owner->id, 'rating' => 8]);
    }
}
