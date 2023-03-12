<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function attemptLogin(Request $request)
    {
        $this->attemptLegacyLogin($request);
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
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
}
