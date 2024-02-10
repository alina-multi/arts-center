<?php

namespace App\Listeners;

use App\Enums\WorkStatuses;
use App\Events\WorkUserPublished;

class TranslateWork
{
    public function handle(WorkUserPublished $event)
    {
        \App\Jobs\TranslateWork::dispatch($event->model)->onQueue('high');
    }
}
