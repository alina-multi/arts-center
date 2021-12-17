<?php

namespace App\Console\Commands;

use App\Work;
use Illuminate\Console\Command;

class TranslateAllWorks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:works';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Work::whereNotNull('published_at')->has('titles', '<', 3)->orderBy('id')->chunk(200, function ($works) {
            foreach ($works as $work) {
                \App\Jobs\TranslateWork::dispatch($work)->onQueue('low');
                print "$work->id\n";
            }
        });
    }
}
