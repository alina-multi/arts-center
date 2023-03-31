<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Work;
use App\Models\WorkBlock;
use Faker\Factory;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's just do this for first 10 works
        $works = Work::query()->orderBy('id')->limit(10)->get();
        $faker = Factory::create('uk_UA');
        foreach ($works as $work) {
            // First image
            $imageBlock = WorkBlock::factory([
                'work_id' => $work->id,
                'type' => 'image',
                'order' => 1,
                'language' => 'uk',
                'data' => [
                    'margin'=>0
                ]
            ])->create();
            $imageBlock->images()->save($work->image);
            // Then text
            $textBlock = WorkBlock::factory([
                'work_id' => $work->id,
                'type' => 'text',
                'order' => 2,
                'language' => 'uk',
                'data' => [
                    'ops' => [
                        ["insert" => $faker->realText($maxNbChars = 200, $indexSize = 2)]
                    ]
                ]
            ])->create();
            // Then grid
            $gridBlock = WorkBlock::factory([
                'work_id' => $work->id,
                'type' => 'grid',
                'order' => 2,
                'language' => 'uk',
                'data' => [
                    'margin'=>0
                ]
            ])->has(Image::factory()->count(6),'images')->create();
        }
    }
}
