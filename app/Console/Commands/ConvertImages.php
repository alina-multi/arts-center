<?php

namespace App\Console\Commands;

use App\Image;
use App\Jobs\ConvertImage;
use Illuminate\Console\Command;

class ConvertImages extends Command
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
        // Find only the ones without a single converted variant
        Image::where([
            ['w300', '=', 0],
            ['w600', '=', 0],
            ['w1200', '=', 0],
            ['w2400', '=', 0],
                     ])->chunk(100, function ($images) {
            foreach ($images as $image) {
                ConvertImage::dispatch($image);
                print "$image->id\n";
            }
        });
    }
}
