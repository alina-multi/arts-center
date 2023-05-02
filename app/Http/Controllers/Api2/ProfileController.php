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
        if (is_array($request->bios)) {
            foreach ($request->bios as $lang => $text) {
                $user->bios()->updateOrCreate(
                    ['language' => $lang],
                    ['text' => $text]
                );
            }
        }
        $user->save();
        return response()->noContent();
    }
}
