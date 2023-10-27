<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Cashier;

class GetPaymentNetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Transaction $transaction)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $paymentIntent = Cashier::stripe()->paymentIntents->retrieve($this->transaction->payment_intent, [
            'expand' => ['latest_charge.balance_transaction']
        ]);
        $bt = $paymentIntent->latest_charge->balance_transaction;
        $amount_net = round($bt->net * 0.92);
        $this->transaction->update([
            'stripe_fee' => $bt->fee,
            'stripe_net' => $bt->net,
            'amount_net' => $amount_net,
            'our_fee' => $bt->net - $amount_net
        ]);
    }
}
