<?php

namespace App\Http\Controllers\Gallery;

use App\Models\Work;

trait RelatedTrait
{
    function relatedGallery($id)
    {
        // Todo: implement related works logic, for now just return single work
        return Work::where('works.id', $id);
    }
}
