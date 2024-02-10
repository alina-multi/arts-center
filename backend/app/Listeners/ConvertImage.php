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
        \App\Jobs\ConvertImage::dispatch($event->image);
    }
}
