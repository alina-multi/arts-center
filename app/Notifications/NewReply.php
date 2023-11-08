<?php

namespace App\Notifications;

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
}
