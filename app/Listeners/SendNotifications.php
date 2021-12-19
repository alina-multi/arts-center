<?php

namespace App\Listeners;

use App\Events\CommentAdded;
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
     * @param  \App\Events\CommentAdded|\App\Events\WorkPublished  $event
     * @return void
     */
    public function handle(CommentAdded|WorkPublished $event)
    {
        //
    }
}
