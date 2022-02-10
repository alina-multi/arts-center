<?php

namespace Tests\Feature;

use App\Blog;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePost()
    {
        $owner = User::factory()->create();
        $translations = [
            ['language' => 'en', 'title' => 'test', 'body' => ["ops" => [["insert" => "super cool post\n"]]]],
            ['language' => 'ru', 'title' => 'тест', 'body' => ["ops" => [["insert" => "супер крутой блог\n"]]]],
        ];
        $blog = Blog::factory()->create();
        $blog->owners()->attach($owner->id);
        $response = $this->actingAs($owner)->postJson('/api/post/', [
            'blog_id' => $blog->id,
            'translations' => $translations
        ]);
        $this->assertDatabaseHas('posts', ['id' => 1]);
        $this->assertDatabaseHas('post_translations', ['post_id' => 1, 'language' => 'en', 'title' => 'test']);
        $this->assertDatabaseHas('post_translations', ['post_id' => 1, 'language' => 'ru', 'title' => 'тест']);
    }

    public function testPostByOtherUser()
    {
        list ($owner, $user) = User::factory()->count(2)->create();
        $blog = Blog::factory()->create();
        $blog->owners()->attach($owner->id);
        $this->actingAs($user)->postJson("/api/post", [
            'blog_id' => $blog->id,
            'translations' => [
                ['language' => 'ru', 'title' => 'test', 'body' => ['delta' => []]]
            ]
        ])->assertStatus(403);
    }

    public function testUpdatePostByOtherUser()
    {
        list ($owner, $user) = User::factory()->count(2)->create();
        $blog = Blog::factory()->create();
        $blog->owners()->attach($owner->id);
        $post = Post::factory(['blog_id' => $blog->id])->hasTranslations(3)->create();
        $this->actingAs($user)->putJson("/api/post/$post->id", [
            'blog_id' => $blog->id,
            'translations' => [
                ['language' => 'ru', 'title' => 'test', 'body' => ['delta' => []]]
            ]
        ])->assertStatus(403);
    }

    public function testUpdatePost()
    {
        $owner = User::factory()->create();
        $blog = Blog::factory()->create();
        $blog->owners()->attach($owner->id);
        $post = Post::factory(['blog_id' => $blog->id])->hasTranslations(3)->create();
        $this->actingAs($owner)->putJson("/api/post/$post->id", [
            'blog_id' => $blog->id,
            'translations' => [
                ['language' => 'ru', 'title' => 'test', 'body' => ['delta' => []]]
            ]
        ])->assertStatus(200);
        $this->assertDatabaseHas('post_translations', ['language' => 'ru', 'title' => 'test']);
        $this->assertDatabaseCount('post_translations', 3);
    }

    public function testDestroyPostByOtherUser()
    {
        list($owner, $user) = User::factory()->count(2)->create();
        $blog = Blog::factory()->create();
        $blog->owners()->attach($owner->id);
        $post = Post::factory(['blog_id' => $blog->id])->hasTranslations(3)->create();
        $this->actingAs($user)->deleteJson("/api/post/$post->id")->assertStatus(403);
    }

    public function testDestroyPost()
    {
        $owner = User::factory()->create();
        $blog = Blog::factory()->create();
        $blog->owners()->attach($owner->id);
        $post = Post::factory(['blog_id' => $blog->id])->hasTranslations(3)->create();
        $this->actingAs($owner)->deleteJson("/api/post/$post->id")->assertStatus(200);
    }

    public function testGetPost()
    {

    }
}
