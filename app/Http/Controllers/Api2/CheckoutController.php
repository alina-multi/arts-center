<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckoutRequest;
use Illuminate\Support\Facades\App;
use Laravel\Cashier\Cashier;

class CheckoutController extends Controller
{
    public function store(CreateCheckoutRequest $request)
    {
        $locale = App::getLocale();
        // Stripe doesn't support Ukrainian for now
        if ($locale === 'uk') {
            $locale = 'auto';
        }
        $session = Cashier::stripe()->checkout->sessions->create([
            'ui_mode' => 'embedded',
            'submit_type' => 'donate',
            'line_items' => [[
                'price' => 'price_1O2zBCFwLM8clJwajfgmg8T9',
                'quantity' => $request->quantity,
            ]],
            'metadata' => [
                'type' => $request->type,
                'user_id' => $request->user_id
            ],
            'custom_fields' => [
                [
                    'key' => 'message',
                    'label' => [
                        'custom' => __('notifications.donation.message'),
                        'type' => 'custom'
                    ],
                    'type' => 'text',
                    'optional' => true
                ]
            ],
            'locale' => $locale,
            'mode' => 'payment',
            'return_url' => UrlHelper::localePath("/{$request->username}/confirmation?session_id={CHECKOUT_SESSION_ID}")
        ]);
        return [
            'clientSecret' => $session['client_secret']
        ];
    }

    public function show($checkout)
    {
        return Cashier::stripe()->checkout->sessions->retrieve($checkout);
    }
}
