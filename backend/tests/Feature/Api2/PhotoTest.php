<?php

use App\Models\UserBio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('photo upload', function () {
    Storage::fake('s3');
    Event::fake();
    $filePath = 'temp/photos/1_1.jpeg';
    $file = UploadedFile::fake()->image("test.jpeg", 1600, 1600);
    Storage::disk('s3')->putFileAs('', $file, $filePath);
    $user = User::factory()->create();
    $this->actingAs($user)->postJson('/api2/photo', [
        'image' => $filePath
    ])->assertNoContent();

    $this->assertDatabaseHas('images', [
        'user_id' => $user->id,
        'folder' => 'photos'
    ]);

    $this->assertDatabaseHas('image_variants', [
        'width' => 1600,
        'height' => 1600,
        'extension' => 'jpeg'
    ]);
});
