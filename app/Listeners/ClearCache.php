<?php

namespace App\Listeners;

use App\Comment;
use App\Events\CommentAdded;
use App\Events\PublishedWorkUpdated;
use App\Events\WorkPublished;
use App\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\ResponseCache\Facades\ResponseCache;

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
            if ($event->model instanceof Comment) {
                ResponseCache::clear(['comment']);
            } elseif ($event->model instanceof Work) {
                ResponseCache::clear(['gallery', 'work']);
            }
        }
    }
}
