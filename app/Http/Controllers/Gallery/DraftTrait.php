<?php

namespace App\Http\Controllers\Gallery;

use App\Work;

trait DraftTrait
{
    function draftGallery()
    {
        return Work::orderBy('created_at', 'DESC')->whereNull('published_at');
    }
}
