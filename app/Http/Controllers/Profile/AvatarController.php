<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $photo = file_get_contents($request->file('file'));
        $fileName = Str::slug($user->name) . '.jpg';
        $image = ImageHelper::upload('photos', $photo, $fileName, $user->id);
        $user->image_id = $image->id;
        $user->save();
        return response()->noContent();
    }
}
