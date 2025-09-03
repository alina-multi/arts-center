<?php

namespace App\Jobs;

use App\Enums\ImageExtentions;
use App\Enums\ImageFolders;
use App\Events\ImageCreated;
use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

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
        $manager = new ImageManager(new Driver());
        $original = $this->work->full->getOriginalFile();
        $image = $manager->read($original);
        
        $cropped = $image->orient()
            ->crop($this->crop['width'], $this->crop['height'], $this->crop['x'], $this->crop['y'])
            ->encode(new JpegEncoder(quality: 80));

        $newImage = $this->work->preview()->create([
            'name' => $this->work->full->name,
            'user_id' => $this->work->full->user_id,
            'folder' => ImageFolders::Preview
        ]);

        $newImage->variants()->create([
            ...$this->crop,
            'extension' => ImageExtentions::jpeg,
            'size' => strlen($cropped->toString()),
            'original' => true
        ]);
        $this->work->update(['image_id' => $newImage->id]);
        $filename = $newImage->getOriginalPath();
        Storage::put($filename, $cropped->toString(), 'public');
        ImageCreated::dispatch($newImage);
    }
}
