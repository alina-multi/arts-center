<?php

namespace App\Http\Controllers\Gallery;

use App\Work;

trait IndexTrait
{
    function indexGallery()
    {
        return Work::orderBy('created_at', 'DESC');
    }
}
