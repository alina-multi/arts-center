<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Jobs\ConvertImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteBigImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:big';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Image::where('w1200', '=', 1)->orWhere('w2400', '=', 1)->chunk(100, function ($images) {
            $pathsToDelete = [];
            foreach ($images as $image) {
                foreach ([1200, 2400] as $width) {
                    $pathsToDelete[] = $this->image->folder . '/' . $image->name . "-w$width.webp";
                    $image->w1200 = 0;
                    $image->w2400 = 0;
                    $image->save();
                }
            }
            Storage::disk('s3')->delete($pathsToDelete);
        });
    }
}
