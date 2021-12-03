<?php

namespace App\Jobs;

use App\Image;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ConvertImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Image $image;
    private array $targets = [
        'works' => [1200, 2400],
        'preview' => [300, 600],
        'photos' => [300, 600],
        'grids' => [300, 600, 1200, 2400],
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->targets[$this->image->folder] as $width) {
            $this->convert($width);
        }
        $this->image->save();
    }

    public function convert($width)
    {
        $url = $this->image->url;
        // So it will work locally
        if (App::environment('local')) {
            $url = str_replace('http://arts2.develop/', 'http://arts2-s3:9000/', $url);
        }
        $client = new Client();
        $response = $client->get('http://arts2-imaginary:9000/resize', [
            'query' => [
                'width' => $width,
                'type' => 'webp',
                'url' => $url,
                'stripmeta' => true
            ]
        ]);
        list($imageNameWithoutExtension) = explode('.', $this->image->name);
        $newFile = $this->image->folder . '/'. $imageNameWithoutExtension. "-w$width.webp";
        Storage::disk('s3')->put($newFile, $response->getBody(),  'public');
        $this->image->{"w$width"}=1;
    }
}
