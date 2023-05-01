<?php

namespace Tests\Old;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateBlog()
    {
        $owner = User::factory()->create();
        $translations = [
            ['language' => 'en', 'title' => 'test', 'about' => ["ops" => [["insert" => "super cool blog\n"]]]],
            ['language' => 'ru', 'title' => 'тест', 'about' => ["ops" => [["insert" => "супер крутой блог\n"]]]],
        ];
        $response = $this->actingAs($owner)->postJson('/api/blog/', [
            'translations' => $translations
        ]);
        $this->assertDatabaseHas('blogs', ['id' => 1]);
        $this->assertDatabaseHas('blog_translations', ['blog_id' => 1, 'language' => 'en', 'title' => 'test']);
        $this->assertDatabaseHas('blog_translations', ['blog_id' => 1, 'language' => 'ru', 'title' => 'тест']);
    }

    public function testUpdateBlogByOtherUser()
    {
        list ($owner, $user) = User::factory()->count(2)->create();
        $blog = Blog::factory()->hasTranslations(3)->create();
        $blog->owners()->attach($owner->id);
        $this->actingAs($user)->putJson("/api/blog/$blog->id", [
            'translations' => [
                ['language' => 'ru', 'title' => 'test', 'about' => ['delta' => []]]
            ]
        ])->assertStatus(403);
    }

    public function testUpdateBlog()
    {
        $owner = User::factory()->create();
        $blog = Blog::factory()->hasTranslations(3)->create();
        $blog->owners()->attach($owner->id);
        $this->actingAs($owner)->putJson("/api/blog/$blog->id", [
            'translations' => [
                ['language' => 'ru', 'title' => 'test', 'about' => ['delta' => []]]
            ]
        ])->assertStatus(200);
        $this->assertDatabaseHas('blog_translations', ['language' => 'ru', 'title' => 'test']);
        $this->assertDatabaseCount('blog_translations', 3);
    }

    public function testDestroyBlogByOtherUser()
    {
        list ($owner, $user) = User::factory()->count(2)->create();
        $blog = Blog::factory()->hasTranslations(3)->create();
        $blog->owners()->attach($owner->id);
        $this->actingAs($user)->deleteJson("/api/blog/$blog->id")->assertStatus(403);
    }

    public function testDestroyBlog()
    {
        $owner = User::factory()->create();
        $blog = Blog::factory()->hasTranslations(3)->create();
        $blog->owners()->attach($owner->id);
        $this->actingAs($owner)->deleteJson("/api/blog/$blog->id")->assertStatus(200);
    }

    public function testGetBlog()
    {
        $blog = Blog::factory()->has(Post::factory()->count(10))->create();
        $this->getJson("/api/blog/$blog->id")->assertJson(fn(AssertableJson $json) => $json
            ->has('blog.id')
            ->has('posts', 10)
        );
    }
}
