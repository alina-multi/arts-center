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
        $key = "frontend.auth.$event->session";
        Redis::connection('externalCache')->del($key);
    }
}
