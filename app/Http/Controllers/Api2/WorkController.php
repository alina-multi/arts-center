<?php

namespace App\Http\Controllers\Api2;

use App\Enums\WorkStatuses;
use App\Events\WorkDeleted;
use App\Events\WorkDrafted;
use App\Events\WorkUserPublished;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PublishWork;
use App\Http\Requests\WorkImagesRequest;
use App\Http\Requests\WorkFormRequest;
use App\Http\Requests\WorkMainImageRequest;
use App\Http\Resources\WorkEditResource;
use App\Jobs\CropWorkImage;
use App\Models\Work;
use App\Models\WorkTitle;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Work::class, 'work');
    }

    public function store(WorkImagesRequest $request)
    {
        $work = Work::create();
        $work->owners()->attach($request->user());
        ImageHelper::attachImages($work, $request->images, $request->user());
        return WorkEditResource::make($work->load('owners', 'images'));
    }

    public function update(WorkFormRequest $request, Work $work)
    {
        foreach ($request->titles ?? [] as $titles) {
            WorkTitle::updateOrCreate([
                'language' => $titles['language'],
                'work_id' => $work->id
            ],[
               'title' => $titles['title'],
               'description' => $titles['description']
            ]);
        }
        $work->category()->sync($request->category);
        return WorkEditResource::make($work->load('owners', 'images', 'titles'));
    }

    public function publish(PublishWork $request, Work $work)
    {
        if ($request->user()->cannot('update', $work)) {
            abort(403);
        }
        $work->published_at = $request->published_at;
        $work->status = WorkStatuses::USER_PUBLISHED;
        $work->save();
        WorkUserPublished::dispatch($work);
        return response()->noContent();
    }

    public function draft(Request $request, Work $work)
    {
        if ($request->user()->cannot('update', $work)) {
            abort(403);
        }
        $work->published_at = null;
        $work->status = WorkStatuses::DRAFT;
        $work->save();
        WorkDrafted::dispatch($work);
        $work->unsearchable();
        return response()->noContent();
    }

    public function mainImage(WorkMainImageRequest $request, Work $work)
    {
        $oldFullImage = $work->full;
        if ($oldFullImage) {
            $work->images()->attach($oldFullImage);
        }
        $work->images()->detach($request->image_id);
        $work->full_image_id = $request->image_id;
        $work->save();
        if ($request->crop) {
            CropWorkImage::dispatchSync($work->load('full'), $request->crop);
        }
        return response()->noContent();
    }

    public function show(Work $work)
    {
        return WorkEditResource::make($work->load('owners', 'images', 'titles', 'category', 'full', 'preview'));
    }

    public function destroy(Work $work)
    {
        if ($work->published_at !== null) {
            abort(403, 'Can not delete published work');
        }
        $work->update(['status' => WorkStatuses::DELETED]);
        $work->delete();
        WorkDeleted::dispatch($work);
        return response()->noContent();
    }
}
