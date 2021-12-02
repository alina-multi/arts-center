<?php

namespace App\Console\Commands;

use App\Image;
use App\Jobs\ConvertImage;
use Illuminate\Console\Command;

class ConvertOldImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:images';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Image::chunk(100, function ($images) {
            foreach ($images as $image) {
                ConvertImage::dispatch($image);
                print "$image->id\n";
            }
        });
    }
}
