<?php

namespace App\Listeners;

use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Events\WebhookReceived;

class CheckoutSessionCompleted
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            DB::transaction(function () use ($event) {
                $total = Arr::get($event->payload, 'data.object.amount_total');
                $user_id = Arr::get($event->payload, 'data.object.metadata.user_id');
                $type = Arr::get($event->payload, 'data.object.metadata.type');
                $email = Arr::get($event->payload, 'data.object.customer_details.email');
                $customFields = collect(Arr::get($event->payload, 'data.object.custom_fields'));
                $message = null;
                if ($messageObj = $customFields->where('key', 'message')->first()) {
                    $message = Arr::get($messageObj, 'text.value');
                    $message = strip_tags($message);
                }

                $net = round($total * 0.9);
                Transaction::create([
                    'to_user_id' => $user_id,
                    'type' => $type,
                    'from_email' => $email,
                    'event' => $event->payload,
                    'amount_gross' => $total,
                    'amount_net' => $net,
                    'message' => $message
                ]);
            });
        }
    }
}
