<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class CleanupSmallUnusedFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;
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
        $pathsToDelete = [];
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
        foreach ([2400, 1200, 600, 300] as $width) {
            if ($originalWidth < $width) {
                $this->image->{"w$width"}=0;
                foreach (['webp', 'jpeg'] as $format) {
                    $path = $this->image->folder . '/' . $this->image->name . "-w$width.$format";
                    if (Storage::disk('s3')->exists($path)) {
                        $pathsToDelete[] = $path;
                    }
                }
            }
        }
        $this->image->save();
        if (sizeof($pathsToDelete)) {
            Storage::disk('s3')->delete($pathsToDelete);
        }
    }
}
