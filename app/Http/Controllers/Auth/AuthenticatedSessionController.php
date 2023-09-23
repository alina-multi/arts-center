<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $this->attemptLegacyLogin($request);
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    function attemptLegacyLogin(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        // 32 we are dealing with old password, let's just try to auth
        if (!empty($user) && strlen($user->password) === 32) {
            if ($user->password === md5('vfktymrbqxfqybr'.$request->password)) {
                // Now save it in laravel format
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
