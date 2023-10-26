<?php

Route::get('/mail/donation_sent/{donation}', function (\App\Models\Transaction $donation) {
    return (new \App\Notifications\DonationSent($donation))->toMail(Notification::route('mail', 'taylor@example.com'));
});
Route::get('/mail/donation_received/{donation}', function (\App\Models\Transaction $donation) {
    return (new \App\Notifications\DonationReceived($donation))->toMail(Notification::route('mail', 'taylor@example.com'));
});
require __DIR__.'/auth.php';
