<?php

namespace App\Jobs;

use App\Enums\WorkStatuses;
use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Work $work)
    {
    }

    public function handle(): void
    {
        if ($this->work->status !== WorkStatuses::READY) {
            throw new \Exception("Shouldn't try to publish work that is not in status READY");
        }
        if (!$this->work->published_at) {
            throw new \Exception("Shouldn't try to publish work that has no published_at");
        }

        $premium = $this->work->owners->where('premium', true)->count();

        $this->work->update(['status' =>
            $premium ?
                WorkStatuses::PUBLISHED_PREMIUM :
                WorkStatuses::PUBLISHED
        ]);
        $this->work->searchable();
    }
}
