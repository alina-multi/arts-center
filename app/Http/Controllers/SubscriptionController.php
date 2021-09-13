<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function redirect(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->createOrGetStripeCustomer();
            $user->redirectToBillingPortal(
                route('home')
            );
        }
        return response()->redirectTo('/');
    }
}
