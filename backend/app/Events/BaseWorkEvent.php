<?php

namespace App\Events;

use App\Models\Work;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BaseWorkEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(public Work $model)
    {
    }
}