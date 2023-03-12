<?php

namespace Database\Seeders;

use App\TagTitle;
use App\Tag;
use App\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory()->count(30)->has(
            TagTitle::factory()->sequence(
            ['language' => 'uk'],
            ['language' => 'en'],
        )->count(2), 'titles')->create();
        Work::chunk(100, function ($works) use ($tags) {
            foreach ($works as $work) {
                $attach = $tags->random(rand(1, 3));
                $work->tags()->attach($attach);
                foreach ($attach as $tag) {
                    $tag->increment('count');
                }
            }
        });
    }
}
