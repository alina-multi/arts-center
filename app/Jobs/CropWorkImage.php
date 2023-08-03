<?php

namespace App\Jobs;

use App\Enums\ImageExtentions;
use App\Enums\ImageFolders;
use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CropWorkImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Work $work, protected $crop)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $original = $this->work->full->getOriginalFile();
        $cropped = Image::make($original)
            ->crop($this->crop['width'], $this->crop['height'], $this->crop['x'], $this->crop['y'])
            ->encode('jpg', 80);

        $newImage = $this->work->image()->create([
            'name' => $this->work->full->name,
            'user_id' => $this->work->full->user_id,
            'folder' => ImageFolders::Preview
        ]);

        $newImage->variants()->create([
            ...$this->crop,
            'extension' => ImageExtentions::jpeg,
            'size' => $cropped->filesize(),
            'original' => true
        ]);
        $this->work->update(['image_id' => $newImage->id]);
        $filename = $newImage->getOriginalPath();
        Storage::put($filename, (string)$cropped);
    }
}
