<?php

namespace App\Http\Controllers\Gallery;

use App\Work;

trait UserTrait
{
    function userGallery($id)
    {
        return Work::whereHas('owners', function ($query) use ($id) {
            $query->where('ownables.user_id', $id);
        });
    }
}
