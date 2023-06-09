<?php

namespace App\Http\Controllers\Api2;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DraftRequest;
use App\Models\Work;
class DraftController extends Controller
{
    public function store(DraftRequest $request)
    {
        $work = Work::create();
        $work->owners()->attach($request->user());
        $moreImages= [];
        foreach ([$request->main, ...$request->more] as $image) {
            $moreImages[] = ImageHelper::createFromUploaded($image, 'works', $request->user()->id, $work->id);
        }
    }
}
