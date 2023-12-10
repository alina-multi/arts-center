<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function store(ImageRequest $request)
    {
        $imageable_class = Relation::morphMap()[$request->imageable_type];
        $imageable = $imageable_class::findOrFail($request->imageable_id);
        if ($request->user()->cannot('update', $imageable)) {
            abort(403);
        }
        foreach ($request->images as $tmpPath) {
            $workId = $request->imageable_type === 'work' ? $request->imageable_id : null;
            $image = ImageHelper::createFromUploaded($tmpPath, $request->folder, $request->user()->id, $workId);
            \DB::table('imageables')->insert([
                'image_id' => $image->id,
                'imageable_type' => $request->imageable_type,
                'imageable_id' => $request->imageable_id
            ]);
            $images[] = $image;
        }
        return response()->json($images, 201);
    }

    public function destroy(Request $request, Image $image)
    {
        if ($request->user()->cannot('delete', $image)) {
            abort(403);
        }
        DB::table('imageables')->where('image_id', $image->id)->delete();
        $image->delete();
        return response()->noContent();
    }
}
