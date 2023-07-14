<?php

namespace App\Console\Commands;

use App\Jobs\ConvertImageBlocks;
use App\Jobs\ConvertTextBlocks;
use App\Models\WorkBlock;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertTextBlocksBatch extends Command
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
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
