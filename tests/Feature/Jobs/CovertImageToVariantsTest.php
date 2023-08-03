<?php

use App\Jobs\ConvertImageToVariants;
use App\Models\ImageVariant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('converting', function () {
    Storage::fake('s3');
    $image = Image::factory()->create(['extension' => 'jpeg']);
    $images = [
        "$image->path.$image->extension"
    ];
    foreach ([300, 600, 1200, 2400] as $width) {
        $images[] = "$image->path-w$width.$image->extension";
    }
    $testFile = UploadedFile::fake()->image("test.$image->extension", 1600, 1600);
    foreach ($images as $imagePath) {
        Storage::putFileAs('', $testFile, $imagePath);
    }
    (new ConvertImageToVariants($image))->handle();

    // Original + 4 variants
    $this->assertDatabaseCount('image_variants', 5);
    $this->assertDatabaseHas('image_variants', [
        'image_id' => 1,
        'original' => 1,
    ]);
    $image->variants()->each(fn(ImageVariant $imageVariant) => Storage::disk('s3')->assertExists("{$image->folder->value}/{$imageVariant->file}"));
})->skip('Most likely this logic will be deleted after we sure it converted fine');
