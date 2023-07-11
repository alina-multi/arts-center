<?php

namespace Tests\Feature\Api2;

use App\Models\UserBio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $user = User::factory()->create();
        $bio = [];
        foreach (['uk', 'en'] as $lang) {
            $bio[$lang] = UserBio::factory()->create([
                'user_id' => $user->id,
                'language' => $lang
            ]);
        }
        $response = $this->actingAs($user)->get('/api2/profile');
        $response->assertOk()->assertJson(
            [
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at->toJson(),
                    'country' => $user->country,
                    'photo' => [
                        // Just to make sure it sends it in this format
                        'src' => $user->photo->src,
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
        $currentPassword = 'paSSword1'; // From UserFactory
        $user = User::factory()->create();

        $this->actingAs($user)->putJson('/api2/profile', [
            ...$user->toArray(),
            'email' => $user->email,
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ])->assertStatus(422, 'Can change password without current password');

        $this->actingAs($user)->putJson('/api2/profile', [
            ...$user->toArray(),
            'email' => $user->email,
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
            'current_password' => 'wrongPassword'
        ])->assertStatus(422, 'Can change password with wrong current password');

        $this->actingAs($user)->putJson('/api2/profile', [
            ...$user->toArray(),
            'email' => $user->email,
            'password' => $invalidPassword,
            'password_confirmation' => $invalidPassword,
            'current_password' => 'wrongPassword'
        ])->assertStatus(422, 'Can change password with unsafe password');

        $this->actingAs($user)->putJson('/api2/profile', [
            ...$user->toArray(),
            'email' => $user->email,
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
            'current_password' => $currentPassword
        ])->assertNoContent();

        $user->refresh();
        $this->assertTrue(\Hash::check($validPassword, $user->password), 'Password was not changed');
    }

    public function test_update_bio()
    {
        $user = User::factory()->create();
        UserBio::factory()->create([
            'user_id' => $user->id,
            'language' => 'uk'
        ]);
        $this->actingAs($user)->putJson('/api2/profile', [
            ...$user->toArray(),
            'email' => $user->email,
            'bios' => [
                'uk' => 'new',
                'en' => 'new'
            ]
        ])->assertNoContent();
        $this->assertDatabaseCount('user_bios', 2)->assertDatabaseHas('user_bios', [
            'user_id' => $user->id,
            'language' => 'uk',
            'text' => 'new'
        ])->assertDatabaseHas('user_bios', [
            'user_id' => $user->id,
            'language' => 'en',
            'text' => 'new'
        ]);
    }

    public function test_photo_upload()
    {
        Storage::fake('s3');
        Storage::disk('s3')->put('photos/cropped.jpg', UploadedFile::fake()->image('photos/cropped.jpg'));
        $user = User::factory()->create();
        $this->actingAs($user)->putJson('/api2/profile', [
            ...$user->toArray(),
            'email' => $user->email,
            'photo' => 'cropped.jpg'
        ])->assertNoContent();

        $this->assertDatabaseHas('images', [
            'user_id' => $user->id,
            'name' => 'cropped',
            'extension' => 'jpg',
        ]);
    }
}
