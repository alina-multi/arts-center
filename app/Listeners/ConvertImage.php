<?php

namespace App\Listeners;

use App\Events\ImageCreated;
use App\Models\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConvertImage
{
    public function handle(ImageCreated $event): void
    {
        //Delay it just in case. There are time from the moment model created to actual file saved
        \App\Jobs\ConvertImage::dispatch($event->image)->delay(now()->addSeconds(5));
    }
}
