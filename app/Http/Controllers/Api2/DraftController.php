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
        $work->blocks()->create([
            'language' => 'zz',
            'type' => 'image',
            'order' => 0,
            'data' => []
        ])->images()->attach(array_shift($moreImages));
        if (sizeof($moreImages)) {
            $gridImages = $work->blocks()->create([
                'language' => 'zz',
                'type' => 'grid',
                'order' => 1,
                'data' => ''
            ])->images();
            foreach ($moreImages as $image) {
                $gridImages->attach($image);
            }
        }
        return WorkEditResource::make($work->load('blocks', 'blocks.images', 'owners'));
    }
}
