<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DraftRequest;
use App\Http\Resources\WorkEditResource;
use App\Models\Work;

class DraftController extends Controller
{
    public function store(DraftRequest $request)
    {
        $work = Work::create();
        $work->owners()->attach($request->user());
        $moreImages = [];
        foreach ([$request->main, ...$request->more] as $image) {
            $moreImages[] = ImageHelper::createFromUploaded($image, 'works', $request->user()->id, $request->user()->id, $work->id);
        }
        $main = array_shift($moreImages);
        $work->update([
            'main_image_id' => $main->id
        ]);
        if (sizeof($moreImages)) {
            foreach ($moreImages as $image) {
                $work->images()->attach($image);
            }
        }
        $work->titles()->create(['language' => $request->language]);
        return WorkEditResource::make($work->load( 'owners', 'images', 'titles'));
    }

    public function show(Work $draft)
    {
        return WorkEditResource::make($draft->load( 'owners', 'images', 'titles'));
    }
}
