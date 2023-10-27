<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageEdit;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('Get stripe net', function () {
    $transaction = \App\Models\Transaction::factory()->createQuietly([
        'amount_gross' => 1500,
        'amount_net' => null,
        'currency' => 'eur',
        'payment_intent' => 'pi_3O5bF1FwLM8clJwa0gjQ4HqU'
    ]);
    \App\Jobs\GetPaymentNetJob::dispatchSync($transaction);
    $transaction->refresh();
    expect($transaction->toArray())->toEqual([
        // Fields we don't care about
        ...$transaction->toArray(),
        // Real calculations we care
        'amount_gross' => 1500,
        'amount_net' => 1371,
        'stripe_net' => 1490,
        'stripe_fee' => 75,
        'our_fee' => 119,
    ]);
});
