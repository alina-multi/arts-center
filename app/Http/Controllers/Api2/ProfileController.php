<?php

namespace App\Http\Controllers\Api2;

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
        $user->fill($request->toArray());
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
            if (Storage::disk('s3')->missing("photos/$request->photo")) {
                \Sentry\captureMessage("File that should have bean uploaded by SvelteKit $request->photo is not found in S3");
            } else {
                list ($name, $extension) = explode('.', $request->photo);
                $image = Image::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'folder' => 'photos',
                    'extension'=> $extension,
                ]);
                $user->image_id = $image->id;
            }
        }
        $user->save();
        return response()->noContent();
    }
}
