<?php

namespace App\Http\Controllers\Api2;

use App\Enums\WorkStatuses;
use App\Events\WorkDeleted;
use App\Events\WorkDrafted;
use App\Events\WorkUserPublished;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PublishWork;
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
        $title = $draft->titles()->where('language', $request->language)->first();
        $title->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        $draft->category()->sync($request->category);
        if ($request->crop) {
            CropWorkImage::dispatchSync($draft, $request->crop);
        }
        return WorkEditResource::make($draft->load('owners', 'images', 'titles'));
    }

    public function publish(PublishWork $request, Work $draft)
    {
        if ($request->user()->cannot('update', $draft)) {
            abort(403);
        }
        $draft->published_at = $request->published_at;
        $draft->status = WorkStatuses::USER_PUBLISHED;
        $draft->save();
        WorkUserPublished::dispatch($draft);
        return response()->noContent();
    }

    public function draft(Request $request, Work $draft)
    {
        if ($request->user()->cannot('update', $draft)) {
            abort(403);
        }
        $draft->published_at = null;
        $draft->status = WorkStatuses::DRAFT;
        $draft->save();
        WorkDrafted::dispatch($draft);
        $draft->unsearchable();
        return response()->noContent();
    }

    public function show(Work $draft)
    {
        return WorkEditResource::make($draft->load('owners', 'images', 'titles', 'category', 'full', 'preview'));
    }

    public function destroy(Work $draft)
    {
        if ($draft->published_at !== null) {
            abort(403, 'Can not delete published work');
        }
        $draft->update(['status' => WorkStatuses::DELETED]);
        $draft->delete();
        WorkDeleted::dispatch($draft);
        return response()->noContent();
    }
}
