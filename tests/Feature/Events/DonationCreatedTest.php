<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('Sends notifications when donation is created', function () {
    Notification::fake();
    $artist = \App\Models\User::factory()->create();
    $donation = \App\Models\Transaction::factory()->create([
        'to_user_id' => $artist->id,
        'type' => \App\Enums\TransactionTypes::DONATION
    ]);
    Notification::assertSentTo($artist, \App\Notifications\DonationReceived::class);
    Notification::assertSentOnDemand(\App\Notifications\DonationSent::class);
});