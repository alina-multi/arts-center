<?php

namespace App\Jobs;

use App\Models\Image;
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
        'grid' => [300, 600, 1200, 2400],
    ];
    private Client $client;

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
        $url = $this->image->original;
        // So it will work locally
        if (App::environment('local')) {
            $url = str_replace('http://arts2.develop', 'http://arts2-s3:9000', $url);
            $url = str_replace('https://arts2.develop', 'http://arts2-s3:9000', $url);
        }
        $this->client = new Client();
        $infoRequest = $this->client->get('http://arts2-imaginary:9000/info', ['query' => ['url' => $url]]);
        $data = json_decode($infoRequest->getBody());
        $originalWidth = $data->width;

        foreach ($this->targets[$this->image->folder] as $width) {
            $this->convert($width, $url, $originalWidth);
        }
        $this->image->save();
    }

    public function convert($width, $url, $originalWidth)
    {
        $path = $this->image->path;

        foreach (['webp', 'jpeg'] as $format) {
            $newFile = "$path-w$width.$format";
            if (!Storage::exists($newFile)) {
                // Don't save if it's already smaller than this breakpoint
                if ($originalWidth > $width) {
                    $response = $this->client->get('http://arts2-imaginary:9000/resize', [
                        'query' => [
                            'width' => $width,
                            'type' => $format,
                            'url' => $url,
                            'stripmeta' => true
                        ]
                    ]);
                    if ($response->getStatusCode() === 200) {
                        $this->image->{"w$width"}=1;
                        Storage::disk('s3')->put($newFile, $response->getBody(),  'public');
                    } else {
                        die("Imaginary failed with message:".$response->getBody());
                    }
                }
            }
        }
    }
}
