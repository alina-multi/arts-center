<?php

namespace App\Notifications;

use App\Helpers\UrlHelper;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReply extends NewWorkComment
{
    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'original_text' => $this->comment->parent->text
        ];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.comment.reply'))
            ->line($this->comment->text)
            ->line(__('notifications.comment.from', ['name' => $this->comment->user->name]))
            ->action(__('notifications.comment.view'), UrlHelper::localePath("/work/{$this->comment->parent->commentable->id}#{$this->comment->parent->id}"));
    }
}
