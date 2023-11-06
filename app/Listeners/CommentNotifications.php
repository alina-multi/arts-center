<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\Work;
use App\Notifications\NewComment;
use App\Notifications\NewReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentNotifications
{
    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->model;
        if ($comment->commentable_type === 'work') {
            /** @var Work $work */
            $work = $comment->commentable;
            $work?->owners?->each(fn($owner) => $owner->notify(new NewComment($comment)));
            if ($comment->parent) {
                $comment?->parent?->user?->notify(new NewReply($comment));
            }
        }
    }
}
