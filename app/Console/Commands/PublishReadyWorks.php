<?php

namespace App\Console\Commands;

use App\Enums\WorkStatuses;
use App\Jobs\PublishWork;
use App\Jobs\ValidateWork;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class PublishReadyWorks extends Command
{
    protected $signature = 'app:publish-ready-works';

    protected $description = 'Publish all works that are ready';

    public function handle()
    {
        \App\Models\Work::where('published_at', '<', now())
            ->where('status', WorkStatuses::READY->value)
            ->chunkById(100, function (Collection $works) {
                $works->map(function ($work) {
                    PublishWork::dispatch($work);
                });
                $this->line("Dispatched batch, last work id: {$works->last()->id}");
            });
    }
}
