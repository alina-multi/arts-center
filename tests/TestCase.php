<?php

namespace Tests;

use App\Tag;
use App\TagTitle;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createTags($tag_type, array $titles)
    {
        $count = sizeof($titles);
        $tags = Tag::factory(['type_id' => $tag_type])->count($count)->create();
        foreach ($titles as $key => $title) {
            TagTitle::factory(['title' => $title, 'tag_id' => $tags[$key]->id])->create();
        }
        return $tags;
    }
}
