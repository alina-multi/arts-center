<?php

namespace App\Notifications;

use App\Enums\NotificationTypes;
use App\Helpers\UrlHelper;
use App\Models\Vote;
use App\Traits\UsesNotificationPreferences;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewWorkVote extends Notification
{
    use Queueable, UsesNotificationPreferences;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Vote $vote)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $user): array
    {
        return $this->filterChannelsByUserPreferences($user, NotificationTypes::MyContentVote, [
            'broadcast',
            'database',
            'mail'
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->vote->user->name,
            'username' => $this->vote->user->username,
            'work_id' => $this->vote->votable->id,
            'work_titles' => $this->vote->votable->titles
        ];
    }


    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.vote.received'))
            ->line(__('notifications.comment.from', ['name' => $this->vote->user->name]))
            ->action(__('notifications.vote.view'), UrlHelper::localePath("/work/{$this->vote->votable_id}"));
    }
}
