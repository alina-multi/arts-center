<?php

namespace App\Http\Controllers\Api2;

use App\Enums\UserIntents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class UserIntentController extends Controller
{
    /**
     * Update the user's intent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'intent' => ['required', new Enum(UserIntents::class)],
        ]);

        $user = $request->user();
        $user->intent = $validated['intent'];
        $user->save();

        return response()->noContent();
    }
}
