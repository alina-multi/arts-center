<?php


namespace App\Http\Controllers;


use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ImageController extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $photo = file_get_contents($request->file('file'));
        $folder = $request->type === 'grid' ? 'grid' : 'image';
        $image = ImageHelper::upload($folder, $photo, $user->id.'.jpg', $user->id);
        return response($image->makeVisible('id'));
    }
}
