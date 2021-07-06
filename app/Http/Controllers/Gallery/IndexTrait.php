<?php

namespace App\Http\Controllers\Gallery;

use App\Work;

trait IndexTrait
{
    function indexGallery()
    {
        return Work::where('rating', '>', '20')->orderBy('created_at', 'DESC');
    }
}
