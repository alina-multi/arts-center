<?php

use Illuminate\Database\Seeder;
use Database\Seeders\GallerySeeder;
use Database\Seeders\WorkSeeder;

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
        $this->call(WorkSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(TagsSeeder::class);
    }
}
