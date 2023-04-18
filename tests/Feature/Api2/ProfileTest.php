<?php

namespace Tests\Feature\Api2;

use App\Models\UserBio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $user = \App\Models\User::factory()->create();
        $bio = [];
        foreach (['uk', 'en'] as $lang) {
            $bio[$lang] = UserBio::factory()->create([
                'user_id' => $user->id,
                'language' => $lang
            ]);
        }
        $response = $this->actingAs($user)->get('/api2/profile');
        $response->assertStatus(200)->assertJson(
            [
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at->toJson(),
                    'country' => $user->country,
                    'avatar' => [
                        // Just to make sure it sends it in this format
                        'src' => $user->avatar->src,
                        'srcset' => $user->avatar->srcset,
                    ],
                    'bios' => [
                        'uk' => $bio['uk']->text,
                        'en' => $bio['en']->text,
                    ]
                ]
            ]
        );
    }
}
