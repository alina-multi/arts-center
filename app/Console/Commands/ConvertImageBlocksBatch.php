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
    protected $signature = 'app:convert-image-blocks';

    protected $batch = 500;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        WorkBlock::whereHas('work', function (Builder $query) {
            $query->whereNull('full_image_id');
        })->whereIn('type', ['image', 'grid'])
            ->with('images')
            ->orderBy('order')
            ->orderBy('id')
            ->chunk($this->batch, function ($blocks) {
                print "Dispatching next $this->batch Last id: {$blocks[0]->id}  \n\n";
                ConvertImageBlocks::dispatch($blocks);
            });
    }
}
