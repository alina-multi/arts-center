<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class testAi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-ai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Helpers\AiHelper::imageCaption('https://i.arts.center/works/517742.jpeg');
    }
}
