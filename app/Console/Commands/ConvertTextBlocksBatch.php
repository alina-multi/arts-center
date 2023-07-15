<?php

namespace App\Console\Commands;

use App\Jobs\ConvertTextBlocks;
use App\Models\WorkBlock;
use Illuminate\Console\Command;

class ConvertTextBlocksBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-text-blocks';

    protected $batch = 100;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        WorkBlock::where('type', 'text')
            ->orderBy('id')
            ->orderBy('order')
            ->chunk($this->batch, function ($blocks) {
                print "Dispatching next $this->batch Last id: {$blocks[0]->id}  \n\n";
                ConvertTextBlocks::dispatch($blocks);
            });
    }
}
