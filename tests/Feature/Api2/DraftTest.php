<?php

namespace Tests\Feature\Api2;

use App\Models\User;
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
}
