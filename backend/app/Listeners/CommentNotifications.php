<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Models\Work;
use App\Notifications\NewWorkComment;
use App\Notifications\NewReply;

class CommentNotifications
{
    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->model;
        if ($comment->commentable_type === 'work') {
            $ownerId = $comment->user->id;
            /** @var Work $work */
            $work = $comment->commentable;
            $work?->owners?->each(function ($owner) use ($comment, $ownerId) {
                if ($owner->id != $ownerId) {
                    $owner->notify(new NewWorkComment($comment));
                }
            });
            if ($comment->parent) {
                if ($comment?->parent?->user->id !== $ownerId) {
                    $comment?->parent?->user?->notify(new NewReply($comment));
                }
            }
        }
    }
}
