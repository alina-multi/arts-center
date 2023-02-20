<?php

use Illuminate\Database\Seeder;
use Database\Seeders\GallerySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GallerySeeder::class);
    }
}
