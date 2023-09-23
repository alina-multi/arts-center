<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request): Response
    {
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = Hash::make($request->email);
        $user->username = Hash::make($request->username);
        $user->name = $request->username; // User can change this later
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
