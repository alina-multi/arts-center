<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use \App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return new ProfileResource($request->user());
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $user->fill($request->toArray());
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return new ProfileResource($user);
    }
}
