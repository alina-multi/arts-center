<?php

namespace Database\Seeders;

use App\Models\Vote;
use Illuminate\Database\Seeder;
use App\Models\Work;

class VotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works = Work::query()->orderBy('id')->limit(10)->get();
        foreach ($works as $work) {
            $votersCount = $work->rating;
            Vote::factory([
                'votable_id' => $work->id,
                'votable_type' => $work->getMorphClass(),
            ])->count($votersCount)->create();
        }
    }
}
