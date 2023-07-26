<?php

use App\Models\UserBio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

/**
 * A basic feature test example.
 *
 * @return void
 */
test('get profile', function () {
    $user = User::factory()->create();
    $bio = [];
    foreach (['uk', 'en'] as $lang) {
        $bio[$lang] = UserBio::factory()->create([
            'user_id' => $user->id,
            'language' => $lang
        ]);
    }
    $this->actingAs($user)->get('/api2/profile')
        ->assertOk()
        ->assertJson([
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
    ]);
});

test('password validation', function () {
    $validPassword = 'newPassword123';
    $invalidPassword = 'newPassword';
    // From UserFactory
    $currentPassword = 'paSSword1';
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
    expect(\Hash::check($validPassword, $user->password))->toBeTrue();
});

test('update bio', function () {
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
});

test('photo upload', function () {
    Storage::fake('s3');
    $filePath = 'temp/photos/1_1.jpeg';
    $file = UploadedFile::fake()->image("test.jpeg", 1600, 1600);
    Storage::disk('s3')->putFileAs('', $file, $filePath);
    $user = User::factory()->create();
    $this->actingAs($user)->putJson('/api2/profile', [
        ...$user->toArray(),
        'email' => $user->email,
        'photo' => $filePath
    ])->assertNoContent();

    $this->assertDatabaseHas('images', [
        'user_id' => $user->id,
        'folder' => 'photos'
    ]);

    $this->assertDatabaseHas('image_variants', [
        'width' => 1600,
        'height' => 1600,
        'extension' => 'jpeg'
    ]);
});
