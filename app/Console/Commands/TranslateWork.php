<?php

namespace App\Console\Commands;

use App\Models\Work;
use Illuminate\Console\Command;

class TranslateWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:work {id} {from?}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $from = $this->argument('from');
        $work = Work::findOrFail($id);
        \App\Jobs\TranslateWork::dispatchSync($work, $from);
    }
}
