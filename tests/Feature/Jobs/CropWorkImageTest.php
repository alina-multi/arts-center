<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageEdit;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('Crops image', function () {
    Storage::fake('s3');

    $image = App\Models\Image::factory()->hasVariants(1, ['original' => true])->create();
    $work = App\Models\Work::factory()->create([
        'full_image_id' => $image->id,
        'image_id' => null
    ]);
    $testFile = Illuminate\Http\UploadedFile::fake()->image("test.jpeg", 800, 800);
    Storage::putFileAs('', $testFile, "{$image->folder->value}/{$image->variants()->first()->file}");
    \App\Jobs\CropWorkImage::dispatchSync($work, [
        'width' => 600,
        'height' => 450,
        'x' => 0,
        'y' => 75
    ]);
    $work->refresh();
    $this->assertTrue(!empty($work->image));
    $this->assertDatabaseHas('image_variants', [
        'width' => 600,
        'height' => 450,
        'original' => true
    ]);
    $path = $work->image->getOriginalPath();

    Storage::assertExists($path);
    $croppedImage = ImageEdit::make(Storage::get($path));
    $this->assertEquals($croppedImage->width(), 600);
    $this->assertEquals($croppedImage->height(), 450);
});
