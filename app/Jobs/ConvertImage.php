<?php

namespace App\Jobs;

use App\Enums\ImageExtentions;
use App\Enums\ImageFolders;
use App\Models\Image;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageManipulator;


class ConvertImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $targets = [
        ImageFolders::Works->name => [1200, 2400],
        ImageFolders::Preview->name => [300, 600],
        ImageFolders::Photos->name => [300, 600],
        ImageFolders::Grids->name => [300, 600, 1200, 2400]
    ];
    private Client $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Image $image)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->image->load('variants');
        $og = ImageManipulator::make($this->image->getOriginalFile())->orientate();
        $og->backup();
        foreach ($this->targets[$this->image->folder->name] as $width) {
            foreach ([ImageExtentions::jpeg->value, ImageExtentions::webp->value] as $extension) {
                $this->convert($width, $extension, $og);
                $og->reset();
            }
        }
        $this->image->save();
    }

    public function convert($width, $extension, \Intervention\Image\Image $og)
    {
        if ($this
            ->image->variants
            ->where('width', $width)
            ->where('extension', $extension)
            ->count()
        ) {
            return;
        }
        if ($width >= $og->width()) {
            return;
        }
        $newImage = $og->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });


        $variant = $this->image->variants()->create([
            'width' => $width,
            'height' => $newImage->height(),
            'size' => $newImage->filesize(),
            'extension' => $extension
        ]);
        $filename = "{$this->image->folder->value}/$variant->file";
        Storage::put($filename, (string)$newImage->encode($extension), 'public');
    }
}
