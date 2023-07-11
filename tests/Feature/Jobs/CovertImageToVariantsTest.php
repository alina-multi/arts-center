<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ConvertImageToVariants;
use App\Models\ImageVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Image;

class CovertImageToVariantsTest extends TestCase
{
    use RefreshDatabase;

    public function testConverting(): void
    {
        $this->markTestSkipped('Most likly this logic will be deleted after we sure it converted fine');
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
    }
}
