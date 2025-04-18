<?php

namespace App\Notifications;

use App\Helpers\UrlHelper;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;

    public function __construct(public Message $message)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'broadcast',
            'database',
            'mail'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.message.subject', ['name' => $this->message->user->name]))
            ->from($this->message->user->email, $this->message->user->name)
            ->line(__('notifications.message.received'))
            ->line($this->message->message)
            ->action(__('notifications.message.go'), UrlHelper::localePath("/my/thread/{$this->message->thread_id}"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'user' => $this->message->user,
            'thread_id' => $this->message->thread_id,
            'created_at' => $this->message->created_at,
        ];
    }
}
