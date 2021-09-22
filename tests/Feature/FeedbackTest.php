<?php

namespace Tests\Feature;

use App\Comment;
use App\Feedback;
use App\Follow;
use App\Tag;
use App\TagTitle;
use App\User;
use App\Work;
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

    public function testGetFeedback()
    {
        Feedback::factory(['type' => 'feedback'])->count(5)->create();
        // To test that we don't send things of different type
        Feedback::factory(['type' => 'idea'])->create();
        Feedback::factory(['type' => 'complaint'])->create();
        $response = $this->getJson('api/feedback/feedback');
        $response->assertJsonCount(5);
    }

    public function testGetIdea()
    {
        Feedback::factory(['type' => 'idea', 'approved_at'=>Carbon::now()])->count(5)->create();
        // To test that we don't send things of different type and not approved yet
        Feedback::factory(['type' => 'complaint'])->create();
        Feedback::factory(['type' => 'feedback'])->create();
        Feedback::factory(['type' => 'idea'])->create();
        $response = $this->getJson('api/feedback/idea');
        $response->assertJsonCount(5);
    }

    public function testGetComplaint()
    {
        Feedback::factory(['type' => 'complaint'])->count(5)->create();
        // To test that we don't send things of different type
        Feedback::factory(['type' => 'idea'])->create();
        Feedback::factory(['type' => 'feedback'])->create();
        $response = $this->getJson('api/feedback/complaint');
        $response->assertJsonCount(5);
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
                'category' => Arr::random(array_slice(Feedback::TYPE_CATEGORY['complaint'],0, -1)), // Remove the last "other"
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
        $data = array_filter(array_merge([
                                'language' => 'en',
                                'title' => $title,
                                'body' => $body
                            ], $data));
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
