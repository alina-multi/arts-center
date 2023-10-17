<?php

namespace App\Listeners;

use App\Events\MeChanged;
use Illuminate\Support\Facades\Redis;

class ClearAuthCache
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(MeChanged $event)
    {
        Redis::connection('externalCache')->del("frontend.auth.$event->session");
    }
}
