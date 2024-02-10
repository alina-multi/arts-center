<?php

namespace App\Console\Commands;

use App\Models\Work;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TranslateWorks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:works  {--status=}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $status = $this->option('status');
        Work::whereNotNull('published_at')
            ->has('titles')
            ->when(isset($status), fn(Builder $query) => $query->where('status', $status))
            ->chunkById(200, function (Collection $works) {
                $works->map(function ($work) {
                    \App\Jobs\TranslateWork::dispatch($work)->onQueue('low');
                });
                $this->line("Dispatched batch, last work id: {$works->last()->id}");
        });
    }
}
