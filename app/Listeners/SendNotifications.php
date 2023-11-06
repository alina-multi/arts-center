<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Events\WorkPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotifications
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CommentNotifications|WorkPublished $event
     * @return void
     */
    public function handle(CommentCreated|WorkPublished $event)
    {
        //
    }
}
