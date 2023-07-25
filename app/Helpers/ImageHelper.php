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
        $name .= '-' . $image->id; //Insert Id as part of name
        //Remove dash if string starts with it
        $name = ltrim($name, '-');
        // And this is silly, but we need to save it again :(
        $image->name = $name;
        $image->save();
        $imageFile = Storage::disk('s3')->put($folder . '/' . $name . '.' . $extension, $file, 'public');

        // If upload failed, delete the image from DB
        if (!$imageFile) {
            $image->delete();
        } else {
            return $image;
        }
    }

    static function createFromUploaded($tmpPath, $folder, $userId, $workId = null)
    {
        if (!Storage::exists($tmpPath)) {
            \Sentry\captureMessage("File that should have bean uploaded by SvelteKit $tmpPath, is not found in S3");
            return;
        }
        list (, $extension) = explode('/', Storage::mimeType($tmpPath));
        $image = Image::create([
            "user_id" => $userId,
            "folder" => $folder,
            "work_id" => $workId,
            "name" => ''
        ]);
        list($width, $height) = getimagesize(Storage::path($tmpPath));
        $variant = $image->variants()->create([
            'extension' => $extension,
            'width' => $width,
            'height' => $height,
            'size' => Storage::size($tmpPath)
        ]);
        Storage::move($tmpPath, "$folder/$variant->file");
        return $image;
    }
}
