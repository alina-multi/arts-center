<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReply extends NewComment
{
    public function toArray(object $notifiable): array
    {
        return [
            ...parent::toArray(),
            'parent' => $this->comment->parent
        ];
    }
    public function broadcastType(): string
    {
        return 'NewReply';
    }
}
