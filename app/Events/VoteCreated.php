<?php

namespace App\Events;

use App\Models\Vote;
use App\Models\Work;
use App\Notifications\NewWorkVote;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Vote $model)
    {
    }
}
