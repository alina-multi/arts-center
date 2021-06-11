<?php

namespace Tests\Feature;

use App\Work;
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

    public function testAddHeader()
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
}
