<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationPreferencesRequest;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationPreferencesController extends Controller
{
    public function update(NotificationPreferencesRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->notificationPreferences()->delete();
        $user->notificationPreferences()->createMany($request->preferences);
        return response()->noContent();
    }

    public function index(Request $request)
    {
        return ['preferences' => $request->user()->notificationPreferences];
    }
}
