<?php

namespace Tests\Feature;

use App\Comment;
use App\Subscription;
use App\Tag;
use App\TagTitle;
use App\User;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testSubscribeToWork()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $response = $this->actingAs($user)->postJson('api/subscription', [
            'subscribable_type' => 'work',
            'subscribable_id' => $work->id
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'subscribable_type' => 'work',
            'subscribable_id' => $work->id
        ]);
    }

    public function testSubscribeExistsValidation()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/subscription', [
            'subscribable_type' => 'work',
            'subscribable_id' => 1
        ]);
        $response->assertStatus(422);
    }

    public function testSubscribeToUser()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/subscription', [
            'subscribable_type' => 'user',
            'subscribable_id' => $user2->id
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'subscribable_type' => 'user',
            'subscribable_id' => $user2->id
        ]);
    }

    public function testUnsubscribeWork()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory([
            'user_id' => $user->id,
            'subscribable_type' => 'work',
            'subscribable_id' => 1
                              ])->create();
        $response = $this->actingAs($user)->deleteJson('api/subscription/' . $subscription->id);
        $response->assertStatus(200);
        $this->assertDatabaseCount('subscriptions',0);
    }

    public function testGetSubscriptions()
    {
        $user = User::factory()->create();
        $subscriptions = Subscription::factory(['user_id' => $user->id])->count(5)->create();
        $response = $this->actingAs($user)->getJson('api/subscription');
        $response->assertJsonCount(5);
    }
}
