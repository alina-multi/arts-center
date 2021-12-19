<?php

namespace App\Listeners;

use App\Events\WorkPublished;
use App\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TranslateWork
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\WorkPublished  $event
     * @return void
     */
    public function handle(WorkPublished $event)
    {
        $work = $event->model;
        if ($work instanceof Work) {
            if (sizeof($work->titles) < 3) {
                \App\Jobs\TranslateWork::dispatch($work)->delay(now()->addSeconds(5))->onQueue('high');
            }
        }
    }
}
