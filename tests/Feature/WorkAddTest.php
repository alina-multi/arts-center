<?php

namespace Tests\Feature;

use App\Image;
use App\Tag;
use App\Work;
use App\WorkBlock;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    }

    public function testUploadImage()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);

        Storage::fake('s3');
        $file = UploadedFile::fake()->image('painting.jpg');

        $response = $this->actingAs($user)->postJson('/api/image', [
            'file' => $file,
            'type' => 'image'
        ]);

        $responseData=$response->decodeResponseJson();

        $response->assertJson(['id' => 1]);

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
        $image = Image::factory(['folder'=>'image'])->create();

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

    public function testAddGridBlock()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);
        $images = Image::factory(['folder'=>'grid'])->count(3)->create();

        $response = $this->actingAs($user)->postJson(
            '/api/edit/block',
            [
                'work_id' => $work->id,
                'type' => 'grid',
                'language' => 'zz',
                'order' => '1',
                'data' => [],
                'images' => $images->makeVisible('id')->toArray()
            ]
        );

        $response->assertStatus(201)->assertJson(['id' => 1]);
        $this->assertDatabaseCount('work_blocks', 1);
        $block = WorkBlock::find(1);
        $this->assertTrue(count($block->images) === 3);
    }

    public function testUpdateWork()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();
        $work->owners()->attach($user->id);
        $image = Image::factory(['folder'=>'image'])->create();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $tags = $this->createTags(Tag::TYPE_TAG,['strawberry', 'banana', 'apple']);
        $category = $this->createTags(Tag::TYPE_CATEGORY,['red', 'blue', 'purple', 'green']);

        $response = $this->actingAs($user)->putJson(
            '/api/works/' . $work->id,
            [
                'image_id' => $image->id,
                'published_at' => $now,
                'tags' => $tags->pluck('id')->toArray(),
                'category' => $category->pluck('id')->toArray()
            ]
        );

        $this->assertDatabaseCount('taggables',7);

        $response->assertStatus(200)->assertJson(['id' => 1]);
        $updatedWork = $work->fresh();
        $this->assertTrue($updatedWork->published_at == $now);
        $this->assertTrue($updatedWork->image_id == $image->id);
    }
}
