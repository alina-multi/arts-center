<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Jobs\ConvertImage;
use App\Rules\OwnsWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\ResponseCache\Facades\ResponseCache;

class AvatarController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'file' => ['required', 'mimes:jpg,webp,png', 'max:20000'],
        ]);
        $user = Auth::user();
        $photo = file_get_contents($request->file('file'));
        $fileName = Str::slug($user->name);
        $image = ImageHelper::upload('photos', $photo, $fileName, $request->file('file')->extension(), $user->id);
        $dimensions = getimagesize($request->file('file'));
        $image->width = $dimensions[0];
        $image->height = $dimensions[1];
        $user->image_id = $image->id;
        $user->save();
        ResponseCache::clear(['user']);
        ConvertImage::dispatch($image);
        return response()->noContent();
    }
}
