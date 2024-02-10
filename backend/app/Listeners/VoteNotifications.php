<?php

namespace App\Listeners;

use App\Events\VoteCreated;
use App\Models\Work;
use App\Notifications\NewWorkVote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VoteNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VoteCreated $event): void
    {
        $model = $event->model;
        if ($model->votable_type === 'work') {
            /** @var Work $votable */
            $model?->votable?->owners?->each(fn($owner) => $owner->notify(new NewWorkVote($model)));
        }
    }
}
