<?php

namespace App\Notifications;

use App\Helpers\UrlHelper;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationSent extends Notification
{
    use Queueable;

    public function __construct(public Transaction $donation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line(__('notifications.donation.sent', ['total' => number_format($this->donation->amount_gross / 100, 2)]))
            ->lineIf($this->donation->message, __('notifications.donation.message'))
            ->lineIf($this->donation->message, $this->donation->message)
            ->action($this->donation->to->name, UrlHelper::localePath('/' . $this->donation->to->username));
    }
}
