<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkTitle;
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
        $users = User::all();
        Event::fake();
        $works = Work::factory()
            ->has(WorkTitle::factory()->sequence(
                    ['language' => 'uk'],
                    ['language' => 'en'],
            )->count(2), 'titles')
            ->count(100)
            ->create();
        foreach ($works as $work) {
            $work->owners()->attach($users->random());
        }
    }
}
