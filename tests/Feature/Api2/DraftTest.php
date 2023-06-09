<?php

namespace Tests\Feature\Api2;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DraftTest extends TestCase
{
    use RefreshDatabase;

    function testCreateDraft()
    {
        Storage::persistentFake('s3');
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
        ])->assertStatus(200);

        $this->assertDatabaseHas('images', [
            'user_id' => $user->id,
        ])->assertDatabaseCount('images', 4); // One image created by user factory
    }

}
