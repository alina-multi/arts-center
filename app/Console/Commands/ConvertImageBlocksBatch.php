<?php

namespace App\Console\Commands;

use App\Jobs\ConvertImageBlocks;
use App\Models\WorkBlock;
use Illuminate\Console\Command;

class ConvertImageBlocksBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-image-blocks {batch=1000}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $batch = $this->argument('batch');
        WorkBlock::whereHas('work', function ($query) {
            $query->whereNull('full_image_id');
        })->whereIn('type', ['image', 'grid'])
            ->with('images')
            ->orderBy('order')
            ->orderBy('id')
            ->chunk($batch, function ($blocks) use ($batch) {
                print "Dispatching next $batch Last id: {$blocks[0]->id}  \n\n";
                ConvertImageBlocks::dispatch($blocks);
            });
    }
}
