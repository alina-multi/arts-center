<?php

namespace Tests\Feature;

use App\Comment;
use App\Subscription;
use App\Tag;
use App\TagTitle;
use App\User;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\DB;

class FeedbackTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSendFeedback()
    {
        $user = User::factory()->create();
        $title = $this->faker()->words(3, true);
        $body = $this->fakeDeltaJson();
        $response = $this->actingAs($user)->postJson('api/feedback', [
            'language' => 'en',
            'title' => $title,
            'body' => $body,
            'type' => 'feedback'
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('feedback', [
            'language' => 'en',
            'title' => $title,
            'type' => 'feedback'
        ]);
    }

}
