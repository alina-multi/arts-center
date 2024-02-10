<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Events\CommentDeleted;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RecountCommentCount
{
    /**
     * Handle the event.
     */
    public function handle(CommentCreated|CommentDeleted $event): void
    {
        /** @var Comment $comment */
        $comment = $event->model;

        /** @var Work|Post $commentable */
        $commentable = $comment->commentable;
        if ($commentable) {
            $commentable->comments = DB::table('comments')
                ->where('commentable_id', $comment->commentable_id)
                ->where('commentable_type', $comment->commentable_type)
                ->whereNull('deleted_at')
                ->count();
            $commentable->save();
        }
    }
}
