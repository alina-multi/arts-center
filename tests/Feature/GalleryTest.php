<?php

namespace Tests\Feature;

use App\Image;
use App\Tag;
use App\TagTitle;
use App\User;
use App\Work;
use App\WorkTitle;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function testDraftGallery()
    {
        $draft = Work::factory()->create();
        $user = User::factory()->create();
        $draft->owners()->attach($user);
        // Add published work to test that it's not in drafts
        Work::factory(['published_at' => date('Y-m-d H:i:s')])->create();
        $response = $this->actingAs($user)->getJson("api/gallery/en/draft_$user->id?order=new");
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->has('works', 1)
            ->has('users', 1)
            ->has('works.0.owners', 1)
        );
        $response = $this->getJson("api/gallery/en/draft_999?order=new");
        $response->assertStatus(404);
    }

    public function testCategoryGallery()
    {
        $work = Work::factory(
            ['rating' => 100, 'published_at' => date('Y-m-d H:i:s', time() - 100), 'show_en'=>1 ]
        )->create();

        WorkTitle::factory(['language' => 'en', 'title' => 'test', 'work_id' => $work->id])->create();

        $user = User::factory()->create();
        $category = Tag::factory(['type_id' => Tag::TYPE_CATEGORY])->has(
            TagTitle::factory(['title' => 'painting', 'language' => 'en']),
            'titles'
        )->create();
        $work->owners()->attach($user);
        $work->category()->attach($category);
        $response = $this->getJson("api/gallery/en/tag_painting?order=new&page=1");
        $response->assertJson(fn(AssertableJson $json) => $json->has('works', 1)
            ->has('users', 1)
            ->has('works.0.owners', 1)
        );
    }
}
