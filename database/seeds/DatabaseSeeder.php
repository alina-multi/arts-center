<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\UsersSeeder::class);
        $this->call(\Database\Seeders\GallerySeeder::class);
        $this->call(\Database\Seeders\WorkSeeder::class);
        $this->call(\Database\Seeders\CommentsSeeder::class);
        $this->call(\Database\Seeders\TagsSeeder::class);
    }
}
