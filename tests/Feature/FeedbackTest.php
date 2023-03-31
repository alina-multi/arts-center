<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Feedback;
use App\Models\Follow;
use App\Models\Tag;
use App\Models\TagTitle;
use App\Models\User;
use App\Models\Vote;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\DB;

class FeedbackTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testGetIdea()
    {
        $voteUser = User::factory()->create();
        $ideas = Feedback::factory(['type' => 'idea', 'approved_at' => Carbon::now()])->count(5)->create();
        // Fake one vote for first of ideas
        Vote::factory()->create(
            ['votable_type' => 'feedback', 'votable_id' => $ideas[0]->id, 'user_id' => $voteUser->id, 'vote' => 1]
        );
        $ideas[0]->rating = 2;
        $ideas[0]->save();
        // To test that we don't send things of different type and not approved yet
        Feedback::factory(['type' => 'complaint'])->create();
        Feedback::factory(['type' => 'feedback'])->create();
        Feedback::factory(['type' => 'idea'])->create();
        $response = $this->getJson('api/feedback/idea/en');
        $response->assertJson(fn(AssertableJson $json) => $json->has('votes', 1)
            ->has('users', 6) // 1x5 ideas + 1 from voting
            ->has('ratings', 5)
            ->has('feedbacks', 5)
        );
    }

    public function testSendFeedback()
    {
        $response = $this->sendAndTestFeedback(['type' => 'feedback']);
    }

    public function testSendIdea()
    {
        $response = $this->sendAndTestFeedback(['type' => 'idea']);
    }

    public function testSendComplaint()
    {
        $user = User::factory()->create();
        $response = $this->sendAndTestFeedback(
            [
                'type' => 'complaint',
                'category' => Arr::random(array_slice(Feedback::TYPE_CATEGORY['complaint'], 0, -1)),
                // Remove the last "other"
                'feedbackable_id' => $user->id,
                'feedbackable_type' => 'user',
                'body' => '',
                'title' => ''
            ]
        );
    }

    public function sendAndTestFeedback($data = [])
    {
        $user = User::factory()->create();
        $title = $this->faker()->words(3, true);
        $body = $this->fakeDeltaJson();
        // Array filter remove empty ones. So if we need to remove element just send it with value ''
        $data = array_filter(
            array_merge([
                            'language' => 'en',
                            'title' => $title,
                            'body' => $body
                        ], $data)
        );
        $response = $this->actingAs($user)->postJson(
            'api/feedback',
            $data

        );
        $response->assertStatus(201);
        unset($data['body']); // todo: make delta validation
        $this->assertDatabaseHas('feedback', $data);
        return $response;
    }

}
