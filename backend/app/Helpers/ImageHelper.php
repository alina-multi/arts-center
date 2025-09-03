<?php

namespace App\Helpers;

use App\Events\ImageCreated;
use App\Models\Image;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $image = Image::create([
            "user_id" => $userId,
            "folder" => $folder,
            "work_id" => $workId,
            "name" => ''
        ]);
        $manager = new ImageManager(new Driver());
        $imageObj = $manager->read(Storage::get($tmpPath));
        $extension = $imageObj->origin()->mediaType();
        $extension = explode('/', $extension)[1]; // Extract extension from mime type
        $variant = $image->variants()->create([
            'extension' => $extension,
            'width' => $imageObj->width(),
            'height' => $imageObj->height(),
            'size' => Storage::size($tmpPath),
            'original' => true
        ]);
        Storage::move($tmpPath, "$folder/$variant->file");
        Storage::setVisibility("$folder/$variant->file", 'public');
        ImageCreated::dispatch($image);
        return $image;
    }

    static function attachImages($work, $tmpImages, $user): void
    {
        foreach ($tmpImages as $image) {
            $uploaded[] = ImageHelper::createFromUploaded($image, 'works', $user->id, $work->id);
        }
        if (sizeof($uploaded)) {
            foreach ($uploaded as $image) {
                $work->images()->attach($image);
            }
        }
    }
}
