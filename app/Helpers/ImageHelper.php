<?php

namespace App\Helpers;

use App\Models\Image;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ImageHelper
{
    static function upload($folder, $file, $name, $extension, $userId = null)
    {
        if (!$userId) {
            $userId = Auth::id();
        };
        $image = Image::create([
            "name" => $name,
            "user_id" => $userId,
            "folder" => $folder,
            "extension" => $extension
        ]);
        $name .= '-'.$image->id; //Insert Id as part of name
        //Remove dash if string starts with it
        $name = ltrim($name, '-');
        // And this is silly but we need to save it again :(
        $image->name = $name;
        $image->save();
        $imageFile = Storage::disk('s3')->put($folder . '/' . $name. '.' . $extension, $file, 'public');

        // If upload failed, delete the image from DB
        if (!$imageFile) {
            $image->delete();
        } else {
            return $image;
        }
    }
}
