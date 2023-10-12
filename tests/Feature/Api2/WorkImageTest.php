<?php

use App\Enums\TagTypes;
use App\Models\Tag;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\{actingAs, assertDatabaseHas};


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('upload more images', function () {
    Storage::fake('s3');
    Bus::fake();
    $user = User::factory()->create();
    $work = Work::factory()->hasTitles()->hasImages(3)->create();
    $work->owners()->attach($user);
    $images = [
        'temp/works/1_1.jpeg',
        'temp/works/1_2.jpeg',
        'temp/works/1_3.jpeg',
    ];
    $testFile = UploadedFile::fake()->image("test.jpeg", 1600, 1600);
    foreach ($images as $image) {
        Storage::disk('s3')->putFileAs('', $testFile, $image);
    }

    actingAs($user)->postJson("/api2/work/$work->id/images", [
        'images' => $images,
    ])->assertOk();
    Bus::assertDispatched(\App\Jobs\ConvertImage::class, 3);
    $work->load('images');
    \PHPUnit\Framework\assertEquals($work->images->count(),6);
});

test('set main image', function () {
    Bus::fake();
    $user = User::factory()->create();
    $work = Work::factory()->hasTitles()->hasImages(3)->create([
        'full_image_id' => \App\Models\Image::factory()->create()->id
    ]);
    $work->owners()->attach($user);
    //If crop is set, all fields should be there
    $imageId = $work->images[0]->id;
    actingAs($user)->putJson("/api2/work/$work->id/images/$imageId", [
        'crop' => [
            'height' => 450,
            'y' => 75
        ]
    ])->assertInvalid(['crop.x', 'crop.width']);

    //AspectRatio validator, should be 4/3
    actingAs($user)->putJson("/api2/work/$work->id/images/$imageId", [
        'crop' => [
            'width' => 600,
            'height' => 400,
            'x' => 0,
            'y' => 75
        ]
    ])->assertInvalid('crop.height');

    actingAs($user)->putJson("/api2/work/$work->id/images/$imageId", [
        'crop' => [
            'width' => 600,
            'height' => 450,
            'x' => 0,
            'y' => 75
        ]
    ])->assertNoContent();
    assertDatabaseHas('works', [
        'full_image_id' => $work->images[0]->id
    ]);
    // Check that image was detacthed from ->images and now only used as main
    \Pest\Laravel\assertDatabaseMissing('imageables', [
        'image_id' => $work->images[0]->id
    ]);
    \Pest\Laravel\assertDatabaseCount('imageables', 3);
    Bus::assertDispatched(\App\Jobs\CropWorkImage::class);
});

test('delete image', function () {
    Bus::fake();
    $user = User::factory()->create();
    $work = Work::factory()->hasTitles()->hasImages(3)->create();
    $work->owners()->attach($user);
    //If crop is set, all fields should be there
    $imageId = $work->images[0]->id;
    actingAs($user)->deleteJson("/api2/work/$work->id/images/$imageId")->assertNoContent();
    \Pest\Laravel\assertDatabaseCount('imageables', 2);
});