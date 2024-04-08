<?php

namespace App\Notifications;

use App\Helpers\UrlHelper;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollower extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $follower)
    {
        //
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->follower->name,
            'username' => $this->follower->username
        ];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.follower.subject'))
            ->action($this->follower->name, UrlHelper::localePath("/{$this->follower->username}"))
            ->line(__('notifications.follower.started_following_you'));
    }
}
