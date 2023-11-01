<?php

namespace App\Http\Controllers\Api2;

use App\Enums\ImageFolders;
use App\Events\MeChanged;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Rules\UploadedImage;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'image' => ['required', 'string', new UploadedImage()]
        ]);
        $image = ImageHelper::createFromUploaded($request->image, ImageFolders::Photos->value, $user->id);
        $user->image_id = $image->id;
        $user->save();
        MeChanged::dispatch($request->cookie('laravel_session'));
        return response()->noContent();
    }
}
