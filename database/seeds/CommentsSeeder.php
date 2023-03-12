<?php

namespace Database\Seeders;

use App\Comment;
use App\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works = Work::query()->orderBy('id')->limit(10)->get();
        foreach ($works as $work) {
            $commentsCount = rand(5, 10);
            $comments = Comment::factory([
                'commentable_id' => $work->id,
                'commentable_type' => $work->getMorphClass(),
            ])->count($commentsCount)->create();
            foreach ($comments as $comment) {
                $subCommentsCount = rand(0, 5);
                if ($subCommentsCount) {
                    $subComments = Comment::factory([
                        'commentable_id' => $work->id,
                        'commentable_type' => $work->getMorphClass(),
                    ])->count($subCommentsCount)->create(['comment_id' => $comment->id, 'depth' => 2]);
                    foreach ($subComments as $subComment) {
                        $subSubCommentsCount = rand(0, 5);
                        if ($subSubCommentsCount) {
                            Comment::factory([
                                'commentable_id' => $work->id,
                                'commentable_type' => $work->getMorphClass(),
                            ])->count($subCommentsCount)->create(['comment_id' => $subComment->id, 'depth' => 3]);
                        }
                    }
                }
            }
        }
    }
}
