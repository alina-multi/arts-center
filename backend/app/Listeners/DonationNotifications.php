<?php

namespace App\Listeners;

use App\Enums\TransactionTypes;
use App\Events\TransactionCreated;
use App\Notifications\DonationReceived;
use App\Notifications\DonationSent;
use DragonCode\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class DonationNotifications implements ShouldQueue
{
    public function handle(TransactionCreated $event): void
    {
        if ($event->model->type === TransactionTypes::DONATION) {
            $event->model->to->notify(new DonationReceived($event->model));
            Notification::route('mail', $event->model->from_email)
                ->notify(new DonationSent($event->model));
        }
    }
}
