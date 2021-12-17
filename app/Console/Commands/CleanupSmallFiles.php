<?php

namespace App\Console\Commands;

use App\Image;
use App\Jobs\CleanupSmallUnusedFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupSmallFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:images';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Image::where('w300', '=', 1)->where('w600', '=', 1)->where('w1200', '=', 0)->chunk(100, function ($images) {
            $pathsToDelete = [];
            foreach ($images as $image) {
                CleanupSmallUnusedFiles::dispatch($image)->onQueue('low');
            }
        });
    }
}
