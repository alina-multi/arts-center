<?php

namespace App\Console\Commands;

use App\Enums\ImageFolders;
use App\Models\Image;
use Illuminate\Console\Command;

class ConvertImagesToVariants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-images-to-variants';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Image::whereDoesntHave('variants')->chunkById(1000, function ($images) {
            foreach ($images as $image) {
                print "Image: $image->id \n";
                dispatch(new \App\Jobs\ConvertImageToVariants($image));
            }
        });
    }
}
