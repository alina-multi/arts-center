<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('Converts image', function () {
    Storage::fake('s3');
    $image = App\Models\Image::withoutEvents(fn() => App\Models\Image::factory(['folder' => \App\Enums\ImageFolders::Works])
        ->hasVariants(1, ['original' => true, 'width' => 2400, 'height' => 2400])->create()
    );
    $testFile = Illuminate\Http\UploadedFile::fake()->image("test.jpeg", 2400, 2400);
    Storage::putFileAs('', $testFile, "{$image->folder->value}/{$image->variants()->first()->file}");
    \App\Jobs\ConvertImage::dispatchSync($image);
    foreach ([\App\Enums\ImageExtentions::webp, \App\Enums\ImageExtentions::jpeg] as $extension) {
        $variant = \App\Models\ImageVariant::where([
            'image_id' => $image->id,
            'width' => 1200,
            'height' => 1200,
            'extension' => $extension,
            'original' => false
        ])->first();
        $this->assertTrue(!empty($variant));
        $filename = "{$image->folder->value}/$variant->file";
        Storage::assertExists($filename);
        $manager = new ImageManager(new Driver());
        $croppedImage = $manager->read(Storage::get($filename));
        $this->assertEquals($croppedImage->width(), 1200);
        $this->assertEquals($croppedImage->height(), 1200);
    }

    // It shouldn't create a second one with the same
    // extensions and size, original covers this already
    $this->assertDatabaseMissing('image_variants', [
        'image_id' => $image->id,
        'width' => 2400,
        'height' => 2400,
        'extension' => \App\Enums\ImageExtentions::jpeg,
        'original' => false
    ]);

    // Make sure not to create the same files again if run multiple times
    $imageVariantsCountBefore = \App\Models\ImageVariant::count();
    \App\Jobs\ConvertImage::dispatchSync($image);
    $this->assertDatabaseCount('image_variants', $imageVariantsCountBefore);
});
