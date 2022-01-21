<?php

namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use App\Rules\OwnsWork;
use App\Work;

class GetEditController extends Controller
{
    public function __invoke($id)
    {
        $ownsWork = new OwnsWork();
        if (!$ownsWork->passes('work_id', $id)) {
            abort(401);
        }
        return Work::where('id', $id)->with('blocks', 'blocks.images', 'titles', 'image')->firstOrFail()->makeVisible('titles');
    }
}
