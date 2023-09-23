<?php

namespace App\Listeners;

use App\Events\WorkTranslated;

class ValidateWork
{
    public function handle(WorkTranslated $event): void
    {
        \App\Jobs\ValidateWork::dispatch($event->model);
    }
}
