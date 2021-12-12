<?php

namespace App\Http\Controllers;

use App\Tag;
use App\TagTitle;
use Google\Cloud\Translate\V2\TranslateClient;
use http\Exception\BadQueryStringException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class TagController extends Controller
{
    public function getCategory($language)
    {
        $rawTags = Tag::with(
            [
                'titles' => function ($query) use ($language) {
                    $query->where('language', $language);
                }
            ]
        )->where('type_id', 1)->orderBy('count', 'desc')->get();

        $tags = $rawTags->keyBy('id')->reject(
            function ($item) {
                return sizeof($item->titles) === 0; //If there are no title for this tag, delete it
            }
        )->map(
            function ($item, $key) {
                return [
                    'title' => $item->titles[0]->title,
                    'count' => $item->count
                ];
            }
        );

        $order = $tags->keys();

        return ['tags' => $tags, 'order' => $order];
    }

    public function show($query)
    {
        if (mb_strlen($query) < 3 || !preg_match('/^\w*$/ui', $query)) {
            abort(422);
        }
        return TagTitle::where('title', 'like', '%' . $query . '%')->whereHas(
            'tag',
            function ($query) {
                $query->where('type_id', Tag::TYPE_TAG);
            }
        )->get();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'language' => ['required'],
                'title' => [
                    'required',
                    Rule::unique('tag_titles')->where(
                        function ($query) use ($request) {
                            return $query->where('language', $request->language);
                        }
                    )
                ]
            ]
        );
        // Todo: logic to find and connect related tags and/or tags on other languages
//        $translate = new TranslateClient(['keyFilePath' => '/var/www/config/google.json']);
//        $languages = array_diff(config('app.languages'), [$request->language]);
//        foreach ($languages  as $language) {
//            $translatedTitle = $translate->translate($request->title, [
//                'target' => $language
//            ]);
//            $tagTitle = TagTitle::where('language', $language)->where('title', $translatedTitle)->first();
//            if ($tagTitle) {
//
//            }
//        }
        $tag = Tag::create(['count' => 1, 'type_id' => Tag::TYPE_TAG, 'old_id' => 0]);
        TagTitle::create(['title' => $request->title, 'language' => $request->language, 'tag_id' => $tag->id]);
        return $tag;
    }

    public function update(Request $request, Tag $tag)
    {
    }

    public function destroy(Tag $tag)
    {
    }

    public function index()
    {
    }
}
