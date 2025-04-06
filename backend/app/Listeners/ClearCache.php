<?php

namespace App\Listeners;

use App;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Redis;

class ClearCache
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        // For now let's make it super simple
        if (isset($event->model)) {
            if ($event->model instanceof Work) {
                $key = "frontend.work.{$event->model->id}";
            }
            if ($event->model instanceof User) {
                $key = "frontend.user.{$event->model->username}";
            }
        }
        if (!empty($key) && !App::environment('testing')) {
            Redis::connection('externalCache')->del($key);
        }
    }
}
