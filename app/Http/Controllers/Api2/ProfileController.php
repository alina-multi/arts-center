<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return new ProfileResource($request->user());
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $user->fill($request->except([
            'username'
        ]));
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if (is_array($request->bios)) {
            foreach ($request->bios as $lang => $text) {
                $user->bios()->updateOrCreate(
                    ['language' => $lang],
                    ['text' => $text ?? '']
                );
            }
        }
        if ($request->photo) {
            $image = ImageHelper::createFromUploaded($request->photo, 'photos', $request->user()->id);
            $user->image_id = $image->id;
        }
        $user->save();
        return response()->noContent();
    }
}
