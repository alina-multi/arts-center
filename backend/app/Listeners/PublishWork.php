<?php

namespace App\Listeners;

use App\Events\WorkReady;
use App\Models\User;
use App\Notifications\NotApprovedUserPublishedWork;
use Illuminate\Support\Facades\Notification;

class PublishWork
{
    public function handle(WorkReady $event): void
    {
        // Shouldn't publish if any of the owners are not approved yet
        foreach ($event->model->owners as $owner) {
            if (!$owner->approved_at) {
                Notification::send(User::admins()->get(), new NotApprovedUserPublishedWork($owner));
                return;
            }
        }
        \App\Jobs\PublishWork::dispatch($event->model);
    }
}
