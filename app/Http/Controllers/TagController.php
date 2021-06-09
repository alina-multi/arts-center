<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
   public function getCategory ($language)
   {
       $rawTags = Tag::with(['titles' => function ($query) use ($language) {
           $query->where('language', $language);
       }])->where('type_id',1)->orderBy('count','desc')->get();

       $tags = $rawTags->keyBy('id')->reject(function ($item) {
           return sizeof($item->titles) === 0; //If there are no title for this tag, delete it
       })->map(function ($item, $key) {
           return [
               'title' => $item->titles[0]->title,
               'count' => $item->count
           ];
       });

       $order = $tags->keys();

       return ['tags'=>$tags, 'order'=>$order];
   }
}
