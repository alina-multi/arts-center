<?php

namespace App\Http\Controllers\Gallery;

use App\TagTitle;
use App\Work;

trait TagTrait
{
    function tagGallery($title, $language)
    {
        if ($title === 'all') {
            return Work::where('image_id','>','0'); //We don't need this condition but we need to start with query builder
        }
        $title = str_replace('+',' ', $title);
        $title = preg_replace('/[^\w ]/u', '', $title);
        $tagTitle = TagTitle::where('title', $title)->where('language',$language)->firstOrFail();
        return Work::whereHas('category', function ($query) use ($tagTitle) {
            $query->where('taggables.tag_id', $tagTitle->tag_id);
        });
    }
}
