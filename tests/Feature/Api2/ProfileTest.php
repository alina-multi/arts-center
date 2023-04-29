<?php

namespace Tests\Feature\Api2;

use App\Models\UserBio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

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
                    'username' => $user->username,
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

    public function test_password_validation()
    {
        $validPassword = 'newPassword123';
        $invalidPassword = 'newPassword';
        $currentPassword = 'password'; // From UserFactory
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/api2/profile', [
            ...$user->toArray(),
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ])->assertStatus(422, 'Can change password without current password');

        $this->actingAs($user)->postJson('/api2/profile', [
            ...$user->toArray(),
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
            'current_password' => 'wrongPassword'
        ])->assertStatus(422, 'Can change password with wrong current password');

        $this->actingAs($user)->postJson('/api2/profile', [
            ...$user->toArray(),
            'password' => $invalidPassword,
            'password_confirmation' => $invalidPassword,
            'current_password' => 'wrongPassword'
        ])->assertStatus(422, 'Can change password with unsafe password');

        $this->actingAs($user)->postJson('/api2/profile', [
            ...$user->toArray(),
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
            'current_password' => $currentPassword
        ])->assertStatus(200, 'Can not change password when everything should be ok');

        $user->refresh();
        $this->assertTrue(\Hash::check($validPassword, $user->password), 'Password was not changed');
    }
}
