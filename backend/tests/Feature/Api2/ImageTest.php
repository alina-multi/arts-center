<?php

use Illuminate\Http\UploadedFile;
use App\Models\{User, Work, Image, Post};


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Create image', function () {
    Storage::fake('s3');
    Event::fake();
    $filePath = 'temp/photos/1_1.jpeg';
    $file = UploadedFile::fake()->image("test.jpeg", 1600, 1600);
    Storage::disk('s3')->putFileAs('', $file, $filePath);
    [$user, $user2] = User::factory()->count(2)->create();
    [$post, $post2] = Post::factory()->count(2)->sequence(['user_id' => $user->id], ['user_id' => $user2->id])->create();

    $this->actingAs($user)->postJson('/api2/image', [
        'imageable_id' => $post2->id,
        'imageable_type' => 'post',
        'folder' => 'posts',
        'images' => [
            $filePath
        ]
    ])->assertForbidden();

    // 2 created by user 2 user factories and nothing else
    \Pest\Laravel\assertDatabaseCount('images', 2);
    \Pest\Laravel\assertDatabaseCount('imageables', 0);

    $this->actingAs($user)->postJson('/api2/image', [
        'imageable_id' => $post->id,
        'imageable_type' => 'post',
        'folder' => 'posts',
        'images' => [
            $filePath
        ]
    ])->assertCreated();

    // 2 created by user 2 user factories on top + 1 new from our request
    \Pest\Laravel\assertDatabaseCount('images', 3);
    \Pest\Laravel\assertDatabaseHas('imageables', [
        'imageable_id' => $post->id,
        'imageable_type' => 'post'
    ]);
});

test('Delete image', function () {
    $user = User::factory()->create();
    $image = Image::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)->deleteJson('/api2/image/'.$image->id)->assertNoContent();
});