<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use \App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return new ProfileResource($request->user());
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $user->fill($request->attributes);
        return new ProfileResource($user);
    }
}
