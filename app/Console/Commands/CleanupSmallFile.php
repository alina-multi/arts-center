<?php

namespace App\Console\Commands;

use App\Image;
use App\Jobs\CleanupSmallUnusedFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupSmallFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:image {name}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $image = Image::where('name', $name)->firstOrFail();
        CleanupSmallUnusedFiles::dispatch($image)->onQueue('high');
    }
}
