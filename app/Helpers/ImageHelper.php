<?php

namespace App\Helpers;

use App\Image;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ImageHelper
{
    static function upload($folder, $file, $name, $userId = null)
    {
        if (!$userId) {
            $userId = Auth::id();
        };
        $image = Image::create([
            "name" => $name,
            "user_id" => $userId,
            "folder" => $folder
        ]);
        $name = str_replace('.', '-' . $image->id . '.', $name); //Insert Id as part of name
        //Remove dash if string starts with it
        $name = ltrim($name, '-');
        // And this is silly but we need to save it again :(
        $image->name = $name;
        $image->save();
        $imageFile = Storage::disk('s3')->put($folder . '/' . $name, $file, 'public');

        // If upload failed, delete the image from DB
        if (!$imageFile) {
            $image->delete();
        } else {
            return $image;
        }
    }
}
