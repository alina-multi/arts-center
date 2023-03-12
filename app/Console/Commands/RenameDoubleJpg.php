<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RenameDoubleJpg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rename:jpg';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       Image::orderBy('id', 'desc')->chunk(200, function ($images) {
           foreach ($images as $image) {
               if (Storage::disk('s3')->exists($image->path.'.jpg.jpg')) {
                   Storage::disk('s3')->move($image->path.'.jpg.jpg',$image->path.'.jpg');
                   print "$image->path\n";
               }
           }
       });
    }
}
