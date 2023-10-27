<?php

namespace App\Listeners;

use App\Jobs\GetPaymentNetJob;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Events\WebhookReceived;
use Stripe\Checkout\Session;

class CheckoutSessionCompleted
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            DB::transaction(function () use ($event) {
                $stripeEvent = \Stripe\Event::constructFrom($event->payload);
                /** @var Session $session */
                $session = $stripeEvent->data->object;
                // Because stipe custom fields are so not convenient!
                $message = Arr::get($event->payload, 'data.object.custom_fields.0.text.value');
                if ($message) {
                    $message = strip_tags($message);
                }
                $transaction = Transaction::create([
                    'to_user_id' => $session->metadata->user_id,
                    'type' => $session->metadata->type,
                    'from_email' => $session->customer_details->email,
                    'event' => $event->payload,
                    'amount_gross' => $session->amount_total,
                    'currency' => $session->currency,
                    'payment_intent' => $session->payment_intent,
                    'message' => $message,
                    'event' => $event->payload
                ]);

                GetPaymentNetJob::dispatchSync($transaction);
            });
        }
    }
}
