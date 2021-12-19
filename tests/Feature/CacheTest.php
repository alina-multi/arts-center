<?php

namespace Tests\Feature;

use App\Comment;
use App\Events\PublishedWorkUpdated;
use App\Jobs\RecountUserRatings;
use App\Tag;
use App\TagTitle;
use App\Vote;
use App\Work;
use App\WorkTitle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Bus;

class CacheTest extends TestCase
{
    use RefreshDatabase;

    public function testResponseCacheWorkingInTestingEnv()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();
        $work->owners()->attach($user->id);
        $comment = Comment::factory()->create(
            [
                'user_id' => $user->id,
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
        // Delete it directly so cache clear wouldn't trigger in model
        DB::table('comments')->where('id', '=', $comment->id)->delete();
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        // We should still se the same result if it's cached
        $this->get('/api/comment/work_' . $work->id)->assertJson(fn(AssertableJson $json) => $json
            ->has('comments', 1)
            ->has('users', 1)->etc()
        );
    }

    public function testWorkTitleChangesInvalidatesCache()
    {
        $work = Work::factory(
            ['rating' => 100, 'published_at' => date('Y-m-d H:i:s', time() - 100), 'show_en' => 1]
        )->create();

        $workTitle = WorkTitle::factory(['language' => 'en', 'title' => 'test', 'work_id' => $work->id])->create();

        $user = User::factory()->create();
        $work->owners()->attach($user);

        $this->getJson("api/gallery/en/tag_all?order=new&page=1")->assertJson(fn(AssertableJson $json) => $json
            ->where('works.0.title', 'test')->etc()
        );
        $workTitle->title = 'new title';
        $workTitle->save();
        $this->getJson("api/gallery/en/tag_all?order=new&page=1")->assertJson(fn(AssertableJson $json) => $json
            ->where('works.0.title', 'new title')->etc()
        );
    }
}
