<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Events\CommentChanged;
use App\Events\WorkUserPublished;
use App\Events\WorkPublished;
use App\Models\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
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
        if (isset($event->model) && !App()->environment('testing')) {
            if ($event->model instanceof Comment) {
                $key = '/api/comment/' . $event->model->commentable_type . '_' . $event->model->commentable_id;
                Redis::connection('externalCache')->del($key);
            } elseif ($event->model instanceof Work) {
                $work = $event->model;
                foreach (['en','ru','uk'] as $lang) {
                    $workKey = "/api/work/$lang/$work->id";
                    Redis::connection('externalCache')->del($workKey);
                }
            }
        }
    }
}
