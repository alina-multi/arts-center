<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Events\PublishedWorkUpdated;
use App\Jobs\RecountUserRatings;
use App\Models\Tag;
use App\Models\TagTitle;
use App\Models\Vote;
use App\Models\Work;
use App\Models\WorkTitle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;

class CacheTest extends TestCase
{
    use RefreshDatabase;

    public function testCommentsCache()
    {
        $work = Work::factory()->create();
        list($workUser, $commentUser) = User::factory()->count(2)->create();
        $work->owners()->attach($workUser->id);
        $comment = Comment::factory()->create(
            [
                'user_id' => $commentUser->id,
                'commentable_id' => $work->id,
                'commentable_type' => 'work',
                'body' => ["ops" => [["insert" => "test\n"]]]
            ]
        );
        // After this it should be cached
        $this->get('/api/comment/work_' . $work->id)->assertJson(fn(AssertableJson $json) => $json
            ->has('comments', 1)
            ->has('users', 1)->etc()
        );

        $this->assertTrue(
            Redis::connection('externalCache')->exists('/api/comment/work_' . $work->id) === 1,
            'Cache not set'
        );

        // Same event dispatched on any change of comment, so let's check only deletion
        $this->actingAs($commentUser)->delete("/api/comment/$comment->id")->assertStatus(200);

        $this->assertFalse(
            Redis::connection('externalCache')->exists('/api/comment/work_' . $work->id) === 1,
            'Cache not deleted after comment deleted'
        );
    }

    public function testWorkCache()
    {
        $work = Work::factory(
            ['rating'=>'100', 'published_at' => date('Y-m-d H:i:s', time() - 100), 'show_en' => 1]
        )->create();
        $title = WorkTitle::factory([ 'language' => 'en', 'title' => 'test', 'work_id' => $work->id])->create();
        $user = User::factory()->create();
        $work->owners()->attach($user->id);
        $workPath = "/api/work/en/$work->id";
        $this->getJson($workPath)->assertStatus(200);
        $this->assertTrue(
            Redis::connection('externalCache')->exists($workPath) === 1,
            'Cache not set'
        );
        $title->title = 'test2';
        $title->save();
        $this->assertFalse(
            Redis::connection('externalCache')->exists($workPath) === 1,
            'Cache not deleted after title changed'
        );
        $this->getJson($workPath)->assertStatus(200);
        $this->assertTrue(
            Redis::connection('externalCache')->exists($workPath) === 1,
            'Cache not set'
        );
        $work->price=33;
        $work->save();
        $this->assertFalse(
            Redis::connection('externalCache')->exists($workPath) === 1,
            'Cache not deleted after work changed'
        );
    }
}
