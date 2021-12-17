<?php

namespace App\Console\Commands;

use App\Image;
use Illuminate\Console\Command;

class ConvertImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:image {name}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $image = Image::where('name', $name)->firstOrFail();
        \App\Jobs\ConvertImage::dispatch($image);
    }
}
