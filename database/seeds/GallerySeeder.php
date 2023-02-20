<?php

namespace Database\Seeders;

use App\Image;
use App\Work;
use App\WorkTitle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::fake();
        $works = Work::factory()
            ->hasOwners(1)
            ->addComments(1, 10)
            ->has(WorkTitle::factory()->sequence(
                    ['language' => 'uk'],
                    ['language' => 'en'],
            )->count(2), 'titles')
            ->count(100)
            ->create();
    }
}
