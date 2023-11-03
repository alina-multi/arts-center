<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkImagesRequest;
use App\Http\Requests\WorkMainImageRequest;
use App\Http\Resources\WorkEditResource;
use App\Jobs\CropWorkImage;
use App\Models\Image;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkImageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Work::class, 'work');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkImagesRequest $request, Work $work)
    {
        ImageHelper::attachImages($work, $request->images, $request->user());
        return WorkEditResource::make($work->load('owners', 'images'));
    }

    /**
     * Make this image the main one, and crop
     */
    public function update(WorkMainImageRequest $request, Work $work, Image $image)
    {
        $oldFullImage = $work->full;
        if ($oldFullImage) {
            $work->images()->attach($oldFullImage);
        }
        $work->images()->detach($image->id);
        $work->full_image_id = $image->id;
        $work->save();
        if ($request->crop) {
            CropWorkImage::dispatchSync($work->load('full'), $request->crop);
        }
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work, Image $image)
    {
        $work->images()->detach($image);
        $image->delete();
        return response()->noContent();
    }
}
