<?php

namespace Tests\Feature;

use App\User;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function testDraftGallery()
    {
        $draft = Work::factory()->create();
        $user = User::factory()->create();
        $draft->owners()->attach($user);
        // Add published work to test that it's not in drafts
        Work::factory(['published_at'=>date('Y-m-d H:i:s')])->create();
        $response = $this->getJson('api/gallery/en/draft?order=new');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('works', 1)
            ->has('users',1)
            ->has('works.0.owners', 1)
        );
    }
}
