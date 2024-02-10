<?php

namespace App\Notifications;

use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewWorkVote extends Notification
{
    use Queueable;

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
    public function via(object $notifiable): array
    {
        return [
            'broadcast',
            'database'
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
            'name' => $this->vote->user->name,
            'username' => $this->vote->user->username,
            'work_id' => $this->vote->votable->id,
            'work_titles' => $this->vote->votable->titles
        ];
    }
}
