<?php

namespace App\Http\Controllers\Gallery;

use App\Work;
use Illuminate\Support\Facades\Auth;

trait DraftTrait
{
    function draftGallery($id)
    {
        if ($id == Auth::id()) {
            return Work::orderBy('created_at', 'DESC')->whereNull('published_at')->whereHas('owners', function ($query) use ($id) {
                $query->where('ownables.user_id', $id);
            });
        }
    }
}
