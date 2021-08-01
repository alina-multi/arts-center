<?php

namespace Tests\Feature;

use App\Tag;
use App\TagTitle;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public $testTitles = ['tagtitle1', 'проверка', 'проtag'];

    function testCreatingTag()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('api/tag',[
            'title' => 'testing',
            'language' => 'en'
        ]);
        $this->assertDatabaseHas('tag_titles',['title'=>'testing', 'language'=>'en', 'tag_id'=>1]);
    }

    public function testGetCategory()
    {
        // Creating both types to test they don't interfere
        $this->createTags(Tag::TYPE_CATEGORY, $this->testTitles);
        $this->createTags(Tag::TYPE_TAG, $this->testTitles);
        $response = $this->getJson('api/tag/category/en');
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('tags', 3)->has('order', 3)
        );
    }

    public function testSearchTags()
    {
        // Creating both types to test they don't interfere
        $this->createTags(Tag::TYPE_CATEGORY, $this->testTitles);
        $this->createTags(Tag::TYPE_TAG, $this->testTitles);
        //Testing wrong format
        $response = $this->getJson('/api/tag/a_@');
        $response->assertStatus(422);
        //Testing to short
        $response = $this->getJson('/api/tag/ab');
        $response->assertStatus(422);
        //Testing successfully multiple search
        $response = $this->getJson('/api/tag/tag');
        $response->assertJsonCount(2);
        //Testing successfully single search
        $response = $this->getJson('/api/tag/верк');
        $response->assertJsonCount(1);
    }
}
