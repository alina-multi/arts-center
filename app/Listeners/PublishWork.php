<?php

namespace App\Listeners;

use App\Events\WorkReady;

class PublishWork
{
    public function handle(WorkReady $event): void
    {
        // Shouldn't publish if any of the owners are not approved yet
        foreach ($event->model->owners as $owner) {
            if (!$owner->approved_at) {
                return;
            }
        }
        \App\Jobs\PublishWork::dispatch($event->model);
    }
}
