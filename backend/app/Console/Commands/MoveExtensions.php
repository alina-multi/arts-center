<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveExtensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:extensions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('images')
            ->orderBy('id', 'DESC')
            ->chunk(200, function ($images) {
                foreach ($images as $image) {
                    if (strtolower(substr($image->name, -4)) === '.jpg') {
                        $name = substr($image->name, 0, -4);
                        $extension = 'jpg';
                        DB::table('images')->where('id', $image->id)->update(['name' => $name, 'extension' => $extension]);
                        print "$name $extension\n";
                    }
                }
            });
    }
}
