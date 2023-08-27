<?php

namespace App\Listeners;

use App\Events\WorkReady;

class PublishWork
{
    public function handle(WorkReady $event): void
    {
        \App\Jobs\PublishWork::dispatch($event->model);
    }
}
