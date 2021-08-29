<?php

namespace Tests\Feature;

use App\Comment;
use App\Feedback;
use App\Subscription;
use App\Tag;
use App\TagTitle;
use App\User;
use App\Work;
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
        Feedback::factory(['type'=>'feedback'])->count(5)->create();
        // To test that we don't send things of different type
        Feedback::factory(['type'=>'idea'])->create();
        Feedback::factory(['type'=>'complaint'])->create();
        $response = $this->getJson('api/feedback/feedback');
        $response->assertJsonCount(5);
    }
    public function testGetIdea()
    {
        Feedback::factory(['type'=>'idea'])->count(5)->create();
        // To test that we don't send things of different type
        Feedback::factory(['type'=>'complaint'])->create();
        Feedback::factory(['type'=>'feedback'])->create();
        $response = $this->getJson('api/feedback/idea');
        $response->assertJsonCount(5);
    }
    public function testGetComplaint()
    {
        Feedback::factory(['type'=>'complaint'])->count(5)->create();
        // To test that we don't send things of different type
        Feedback::factory(['type'=>'idea'])->create();
        Feedback::factory(['type'=>'feedback'])->create();
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
        $response = $this->sendAndTestFeedback(['type' => 'complaint', 'category' => Arr::random(Feedback::TYPE_CATEGORY['complaint'])]);
    }

    public function sendAndTestFeedback($data = [])
    {
        $user = User::factory()->create();
        $title = $this->faker()->words(3, true);
        $body = $this->fakeDeltaJson();
        $data = array_merge([
                                'language' => 'en',
                                'title' => $title,
                                'body' => $body
                            ], $data);
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
