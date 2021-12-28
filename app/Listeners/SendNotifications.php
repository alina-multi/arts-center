<?php

namespace App\Listeners;

use App\Events\CommentChanged;
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
     * @param  \App\Events\CommentChanged|\App\Events\WorkPublished  $event
     * @return void
     */
    public function handle(CommentChanged|WorkPublished $event)
    {
        //
    }
}
