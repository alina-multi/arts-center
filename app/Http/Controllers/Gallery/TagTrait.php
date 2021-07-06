<?php

namespace App\Http\Controllers\Gallery;

use App\TagTitle;
use App\Work;

trait TagTrait
{
    function tagGallery($title, $request)
    {
        if ($title === 'all') {
            return Work::where('image_id','>','0'); //We don't need this condition but we need to start with query builder
        }
        $title = str_replace('+',' ', $title);
        $title = preg_replace('/[^\w ]/u', '', $title);
        $tag = TagTitle::where('title', $title)->firstOrFail();
        return Work::whereHas('tags', function ($query) use ($tag) {
            $query->where('taggables.tag_id', $tag->id);
        });
    }
}
