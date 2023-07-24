<?php

namespace Tests\Feature\Api2;

use App\Enums\TagTypes;
use App\Models\Tag;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class DraftTest extends TestCase
{
    use RefreshDatabase;

    function testCreateDraft()
    {
        Storage::fake('s3');
        $images = [
            'temp/works/1_1.jpeg',
            'temp/works/1_2.jpeg',
            'temp/works/1_3.jpeg',
        ];
        $testFile = UploadedFile::fake()->image("test.jpeg", 1600, 1600);
        foreach ($images as $image) {
            Storage::disk('s3')->putFileAs('', $testFile, $image);
        }
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/api2/draft', [
            'main' => array_shift($images),
            'more' => $images,
            'language' => 'en',
        ])->assertStatus(201)
            ->assertJson(fn(AssertableJson $json) => $json->where('id', 1)
                ->has('owners', 1)
                ->has('images', 2)
                ->has('titles', 1)
                ->etc()
            );
    }

    public function testEditDraft()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $categories = Tag::factory(
            [
                'type_id' => TagTypes::CATEGORY
            ]
        )->count(2)->create();
        $tag = Tag::factory(['type_id' => TagTypes::TAG])->create();
        $categoryIds = $categories->pluck('id');
        $tagIds = [$tag->id];
        $work = Work::factory([
            'published_at' => null,
            'show_uk' => false,
            'show_en' => false,
            'price' => 0,
            'rating' => 0,
            'comments' => 0
        ])->hasTitles()->create();
        $work->owners()->attach($user);

        $this->actingAs($otherUser)->putJson("/api2/draft/$work->id")
            ->assertStatus(403);

        $this->actingAs($user)->putJson("/api2/draft/$work->id", [
            'title' => 'test',
            'category' => [...$categoryIds,...$tagIds]
        ])->assertStatus(422);

        $this->actingAs($user)->putJson("/api2/draft/$work->id", [
            'title' => 't',
            'category' => $categoryIds
        ])->assertStatus(422);

        $validStringButWithHtml = '<b>Valid but with html</b>';
        $this->actingAs($user)->putJson("/api2/draft/$work->id", [
            'title' => $validStringButWithHtml,
            'description' => $validStringButWithHtml,
            'category' => $categoryIds
        ])->assertStatus(200);

        $this->assertDatabaseHas('work_titles', [
            'title' => strip_tags($validStringButWithHtml),
            'description' => strip_tags($validStringButWithHtml),
        ]);

        $this->assertEquals($work->category()->count(), sizeof($categoryIds));
    }

    function testGetDraft()
    {
        $user = User::factory()->create();
        $work = Work::factory()->hasTitles()->create();
        $work->owners()->attach($user);
        $this->actingAs($user)->getJson("/api2/draft/$work->id")
            ->assertStatus(200);
    }
}
