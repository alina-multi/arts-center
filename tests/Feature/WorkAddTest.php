<?php

namespace Tests\Feature;

use App\Image;
use App\Tag;
use App\Work;
use App\WorkBlock;
use App\WorkTitle;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;

class WorkAddTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateWork()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/works');
        $response->assertStatus(200)->assertJson(['id' => 1]);
        $this->assertDatabaseHas('ownables', [
            'user_id' => $user->id,
            'ownable_type' => 'work',
            'ownable_id' => 1
        ]);
    }

    public function testAddTextBlock()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);

        $response = $this->actingAs($user)->postJson(
            '/api/edit/block',
            [
                'work_id' => $work->id,
                'type' => 'text',
                'language' => 'en',
                'order' => '1',
                'data' => []
            ]
        );
        $response->assertStatus(201)->assertJson(['id' => 1]);
        $this->assertDatabaseCount('work_blocks', 1);
    }

    public function testAddTitle()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);

        $response = $this->actingAs($user)->postJson(
            '/api/edit/title',
            [
                'work_id' => $work->id,
                'title' => 'text',
                'language' => 'en'
            ]
        );
        $response->assertStatus(201)->assertJson(['id' => 1]);
        $this->assertDatabaseHas('work_titles', [
            'title' => 'text',
            'language' => 'en'
        ]);
        $this->assertDatabaseHas('works', [
            'show_en' => 1
        ]);
    }

    public function testUploadImage()
    {
        $imageName = 'painting.jpg';
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);

        Storage::fake('s3');
        $file = UploadedFile::fake()->image($imageName);

        $response = $this->actingAs($user)->postJson('/api/image', [
            'file' => $file,
            'type' => 'image'
        ]);

        $responseData = $response->decodeResponseJson();

        $response->assertJson(['url' => $responseData['url']]);

        Storage::disk('s3')->assertExists($responseData['url']);

        $this->assertDatabaseHas('images', [
            'id' => $responseData['id']
        ]);
    }

    public function testAddImageBlock()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);
        $image = Image::factory(['folder' => 'image'])->create();

        $response = $this->actingAs($user)->postJson(
            '/api/edit/block',
            [
                'work_id' => $work->id,
                'type' => 'image',
                'language' => 'zz',
                'order' => '1',
                'data' => [],
                'images' => [
                    $image->makeVisible('id')->toArray()
                ]
            ]
        );

        $response->assertStatus(201)->assertJson(['id' => 1]);
        $this->assertDatabaseCount('work_blocks', 1);
        $block = WorkBlock::find(1);
        $this->assertTrue(sizeof($block->images) === 1);
    }

    public function testAddAndUpdateGridBlock()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);
        $images = Image::factory(['folder' => 'grid'])->count(3)->create();

        $response = $this->actingAs($user)->postJson(
            '/api/edit/block',
            [
                'work_id' => $work->id,
                'type' => 'grid',
                'language' => 'zz',
                'order' => '1',
                'data' => ['one' => 'two'],
                'images' => $images->makeVisible('id')->toArray()
            ]
        );

        $this->assertDatabaseCount('work_blocks', 1);
        $block = WorkBlock::find(1);
        $this->assertTrue(count($block->images) === 3);
        $response->assertStatus(201)->assertJson(
            fn(AssertableJson $json) => $json->has('images', 3)
                ->where('order', '1')
                ->where('data.one', 'two')
                ->etc()
        );

        //Now let's update the same block
        $images = Image::factory(['folder' => 'grid'])->count(2)->create();

        $response = $this->actingAs($user)->putJson(
            '/api/edit/block/' . $block->id,
            [
                'order' => '3',
                'data' => ['foo' => 'bar'],
                'images' => $images->makeVisible('id')->toArray()
            ]
        );

        $response->assertStatus(200)->assertJson(
            fn(AssertableJson $json) => $json->has('images', 2)
                ->where('order', '3')
                ->where('data.foo', 'bar')
                ->etc()
        );
    }

    public function testUpdateWork()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);
        WorkTitle::factory()->create(['work_id' => $work->id, 'language' => 'en']);
        $image = Image::factory(['folder' => 'image'])->create();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $tags = $this->createTags(Tag::TYPE_TAG, ['strawberry', 'banana', 'apple']);
        $category = $this->createTags(Tag::TYPE_CATEGORY, ['red', 'blue', 'purple', 'green']);

        // Test that before saving gallery is empty, and it will cache
        $this->getJson("api/gallery/en/tag_all?order=new&page=1")
            ->assertJson(fn(AssertableJson $json) =>
            $json->has('works', 0)
            ->has('users', 0)
        );

        $response = $this->actingAs($user)->putJson(
            '/api/works/' . $work->id,
            [
                'image_id' => $image->id,
                'published_at' => $now,
                'tags' => $tags->pluck('id')->toArray(),
                'category' => $category->pluck('id')->toArray()
            ]
        );

        $response->assertStatus(200)->assertJson(['id' => 1]);
        $updatedWork = $work->fresh();
        $this->assertTrue($updatedWork->published_at == $now, 'works.published_at is wrong');
        $this->assertTrue($updatedWork->image_id == $image->id, 'works.image_id is wrong');
        $this->assertTrue($updatedWork->show_en == 1, 'works.show_en is not set');

        $this->assertDatabaseCount('taggables', 7);

        // And now we have 1 work and cache is invalidated
        $this->getJson("api/gallery/en/tag_all?order=new&page=1")
            ->assertJson(fn(AssertableJson $json) =>
            $json->has('works', 1)
                ->has('users', 1)
                ->has('works.0.owners', 1)
            );
    }
}
