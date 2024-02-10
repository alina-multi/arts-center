<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileApproved extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(object $notifiable): array
    {
        return [
            'broadcast',
            'database',
            'mail'
        ];
    }

    public function toArray(): array
    {
        return [];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->line(__('notifications.profile.approved'));
    }
}
