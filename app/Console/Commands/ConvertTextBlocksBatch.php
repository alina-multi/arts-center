<?php

namespace App\Console\Commands;

use App\Jobs\ConvertImageBlocks;
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

    protected $batch = 1000;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        WorkBlock::where('type', 'text')
            ->orderBy('order')
            ->orderBy('id')
            ->chunk($this->batch, function ($blocks) {
                ConvertTextBlocksBatch::dispatch($blocks);
            });
    }
}
