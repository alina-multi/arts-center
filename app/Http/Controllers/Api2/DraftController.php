<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkDraftRequest;
use App\Http\Requests\WorkEditRequest;
use App\Http\Resources\WorkEditResource;
use App\Models\Work;

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
        return WorkEditResource::make($draft->load('owners', 'images', 'titles'));
    }

    public function show(Work $draft)
    {
        return WorkEditResource::make($draft->load('owners', 'images', 'titles', 'category', 'full'));
    }
}
