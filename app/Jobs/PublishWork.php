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

    public function __construct(public Work $model)
    {
    }

    public function handle(): void
    {
        if ($this->model->status->value < WorkStatuses::READY->value) {
            throw new \Exception("Shouldn't try to publish work that is not in status READY");
        }
        if (!$this->model->published_at) {
            throw new \Exception("Shouldn't try to publish work that has no published_at");
        }

        $premium = $this->model->owners->where('premium', true)->count();

        $this->model->status = $premium ?
                WorkStatuses::PUBLISHED_PREMIUM :
                WorkStatuses::PUBLISHED;
        $this->model->save();
        $this->model->searchable();
    }
}
