<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class BlogPostContent extends Notification
{
    use Queueable;

    public function __construct(public Post $model)
    {
    }

    public function via(object $notifiable): array
    {
        return [
            // todo: uncomment before commit :) 'mail',
            'broadcast',
            'database'
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->model->refresh();
        return (new MailMessage)
            ->subject($this->model->title)
            ->markdown('mail.post', ['text' => $this->model->text])
            ;
    }

    public function toArray()
    {
        return $this->model->toArray();
    }
}
