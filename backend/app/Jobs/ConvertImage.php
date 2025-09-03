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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\WebpEncoder;

class ConvertImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $targets = [
        ImageFolders::Works->name => [300, 400, 600, 1200, 2400],
        ImageFolders::Preview->name => [150, 200, 250, 300, 400, 600],
        ImageFolders::Photos->name => [64, 300, 600],
        ImageFolders::Grids->name => [150, 300, 600, 1200, 2400],
        ImageFolders::Posts->name => [150, 300, 600, 1200],
    ];
    private Client $client;
    private ImageManager $manager;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Image $image)
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->image->load('variants');
        foreach ($this->targets[$this->image->folder->name] as $width) {
            foreach ([ImageExtentions::jpeg->value, ImageExtentions::webp->value] as $extension) {
                $this->convert($width, $extension);
            }
        }
        $this->image->save();
    }

    public function convert($width, $extension)
    {
        if ($this
            ->image->variants()
            ->where('width', $width)
            ->where('extension', $extension)
            ->count()
        ) {
            return false;
        }
        
        $og = $this->manager->read($this->image->getOriginalFile())->orient();
        if ($width >= $og->width()) {
            return false;
        }
        $newImage = $og->scale(width: $width);

        $variant = $this->image->variants()->create([
            'width' => $width,
            'height' => $newImage->height(),
            'size' => strlen($this->encodeImage($newImage, $extension)->toString()),
            'extension' => $extension
        ]);
        $filename = "{$this->image->folder->value}/$variant->file";
        Storage::put($filename, $this->encodeImage($newImage, $extension)->toString(), 'public');
    }

    private function encodeImage(ImageInterface $image, string $extension)
    {
        return match($extension) {
            'jpeg', 'jpg' => $image->encode(new JpegEncoder(quality: 80)),
            'webp' => $image->encode(new WebpEncoder(quality: 80)),
            default => $image->encode(new JpegEncoder(quality: 80))
        };
    }
}
