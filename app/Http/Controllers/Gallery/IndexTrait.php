<?php

namespace App\Http\Controllers\Gallery;

use App\Models\Work;

trait IndexTrait
{
    function indexGallery()
    {
        return Work::where('rating', '>', '20');
    }
}
