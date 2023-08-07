<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkDraftRequest;
use App\Http\Requests\WorkEditRequest;
use App\Http\Resources\WorkEditResource;
use App\Jobs\CropWorkImage;
use App\Models\Work;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Work::class, 'draft');
    }

    public function store(WorkDraftRequest $request)
    {
        $work = Work::create();
        $work->owners()->attach($request->user());
        $moreImages = [];
        foreach ([$request->main, ...$request->more] as $image) {
            $moreImages[] = ImageHelper::createFromUploaded($image, 'works', $request->user()->id, $work->id);
        }
        $main = array_shift($moreImages);
        $work->update([
            'full_image_id' => $main->id
        ]);
        if (sizeof($moreImages)) {
            foreach ($moreImages as $image) {
                $work->images()->attach($image);
            }
        }
        $work->titles()->create(['language' => $request->language]);
        return WorkEditResource::make($work->load('owners', 'images', 'titles', 'full'));
    }

    public function update(WorkEditRequest $request, Work $draft)
    {
        $title = $draft->titles()->first();
        $title->update([
            'title'=>$request->title,
            'description' => $request->description
        ]);
        $draft->category()->attach($request->category);
        if ($request->crop) {
            CropWorkImage::dispatchSync($draft, $request->crop);
        }
        return WorkEditResource::make($draft->load('owners', 'images', 'titles'));
    }

    public function publish(Request $request, Work $work)
    {
        $validated = $request->validate([
            'published_at' => ['required', 'date_format:Y-m-d'],
        ]);
        $work->published_at = $validated['published_at'].' 00:00:00';
        $work->save();
        return response()->noContent();
    }

    public function show(Work $draft)
    {
        return WorkEditResource::make($draft->load('owners', 'images', 'titles', 'category', 'full', 'image'));
    }
}
