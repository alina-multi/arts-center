<?php

namespace App\Console\Commands;

use App\Work;
use Illuminate\Console\Command;

class TranslateWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:work {id}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $work = Work::findOrFail($id);
        \App\Jobs\TranslateWork::dispatch($work);
    }
}
