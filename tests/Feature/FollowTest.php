<?php

namespace Tests\Feature;

use App\Follow;
use App\User;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    public function testFollowToWork()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $response = $this->actingAs($user)->postJson('api/follow', [
            'followable_type' => 'work',
            'followable_id' => $work->id
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('follows', [
            'user_id' => $user->id,
            'followable_type' => 'work',
            'followable_id' => $work->id
        ]);
    }

    public function testFollowExistsValidation()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/follow', [
            'followable_type' => 'work',
            'followable_id' => 1
        ]);
        $response->assertStatus(422);
    }

    public function testFollowToUser()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/follow', [
            'followable_type' => 'user',
            'followable_id' => $user2->id
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('follows', [
            'user_id' => $user->id,
            'followable_type' => 'user',
            'followable_id' => $user2->id
        ]);
    }

    public function testUnfollowWork()
    {
        $user = User::factory()->create();
        $follow = Follow::factory([
            'user_id' => $user->id,
            'followable_type' => 'work',
            'followable_id' => 1
                              ])->create();
        $response = $this->actingAs($user)->deleteJson('api/follow/' . $follow->id);
        $response->assertStatus(200);
        $this->assertDatabaseCount('follows',0);
    }

    public function testGetFollows()
    {
        $user = User::factory()->create();
        $follows = Follow::factory(['user_id' => $user->id])->count(5)->create();
        $response = $this->actingAs($user)->getJson('api/follow');
        $response->assertJsonCount(5);
    }

    public function testGetFullFollows()
    {
        $user = User::factory()->create();
        Follow::factory(['user_id'=>$user->id])->attachWork()->create();
        Follow::factory(['user_id'=>$user->id])->attachUser()->create();
        $response = $this->actingAs($user)->getJson('api/follow?full=1');
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('follows', 2)
            ->has('users', 1)
            ->has('works', 1)
            ->has('works.1.image.url')
        );
    }

    public function testDoubleFollow()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $response1 = $this->actingAs($user)->postJson('api/follow', [
            'followable_type' => 'work',
            'followable_id' => $work->id
        ]);
        $response1->assertStatus(201);
        $response2 = $this->actingAs($user)->postJson('api/follow', [
            'followable_type' => 'work',
            'followable_id' => $work->id
        ]);
        $response2->assertStatus(422);
    }
}
