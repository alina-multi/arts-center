<?php

namespace App\Console\Commands;

use App\Jobs\ValidateWork;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ValidateWorks extends Command
{
    protected $signature = 'app:validate-works';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate all works';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\Work::whereNotNull('published_at')
            ->chunkById(100, function (Collection $works) {
                $works->map(function ($work) {
                    ValidateWork::dispatch($work);
                });
                $this->line("Dispatched batch, last work id: {$works->last()->id}");
            });
    }
}
