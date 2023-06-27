<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\ImageVariant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Enums\ImageVariantFolders;
use Illuminate\Support\Facades\Storage;

class ConvertImageToVariants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Image $image)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->copy("{$this->image->path}.{$this->image->extension}", true);
        foreach ([300, 600, 1200, 2400] as $width) {
            foreach (['webp', 'jpg', 'jpeg'] as $extension) {
                $this->copy("{$this->image->path}-w$width.$extension");
            }
        }
    }

    public function copy($oldPath, $og = false)
    {
        if (!Storage::has($oldPath)) {
            return;
        }
        // create
        $url = Storage::url($oldPath);
        $url = str_replace('fra1.digitaloceanspaces.com', 'i.arts.center', $url);
        if (str_starts_with($url, '/storage')) {
            $url = storage_path(str_replace('/storage/', '/framework/testing/disks/s3', $url));
        }
        list($width, $height, $imageType) = getimagesize($url);
        $variant = ImageVariant::create([
            'image_id' => $this->image->id,
            'extension' => substr(image_type_to_extension($imageType), 1),
            'width' => $width,
            'height' => $height,
            'size' => Storage::size($oldPath),
            'original' => $og,
        ]);
        Storage::copy($oldPath, $this->image->folder->value . '/' . $variant->file);
    }
}
