<?php

namespace App\Console\Commands;

use App\Jobs\ValidateWork;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ValidateWorks extends Command
{
    protected $signature = 'app:validate-works {--status=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate works';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status = $this->option('status');
        \App\Models\Work::whereNotNull('published_at')
            ->when(isset($status), fn(Builder $query) => $query->where('status', $status))
            ->chunkById(100, function (Collection $works) {
                $works->map(function ($work) {
                    ValidateWork::dispatch($work);
                });
                $this->line("Dispatched batch, last work id: {$works->last()->id}");
            });
    }
}
