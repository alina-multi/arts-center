<?php

namespace App\Notifications;

use App\Enums\NotificationTypes;
use App\Helpers\UrlHelper;
use App\Models\Comment;
use App\Models\User;
use App\Traits\UsesNotificationPreferences;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewWorkComment extends Notification
{
    use Queueable, UsesNotificationPreferences;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Comment $comment)
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
        return $this->filterChannelsByUserPreferences($user, NotificationTypes::MyContentComment, [
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
            'text' => $this->comment->text,
            'name' => $this->comment->user->name,
            'username' => $this->comment->user->username,
            'work_id' => $this->comment->commentable->id,
            'work_titles' => $this->comment->commentable->titles,
            'comment_id' => $this->comment->id
        ];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.comment.received'))
            ->line($this->comment->text)
            ->line(__('notifications.comment.from', ['name' => $this->comment->user->name]))
            ->action(__('notifications.comment.view'), UrlHelper::localePath("/{$this->comment->commentable_type}/{$this->comment->commentable_id}#{$this->comment->id}"));
    }
}
