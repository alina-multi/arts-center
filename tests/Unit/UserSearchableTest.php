<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserBio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSearchableTest extends TestCase
{
    use RefreshDatabase;

    public function testToSearchableArray(): void
    {
        $fieldsThatShouldBePresent = ['id', 'name', 'email', 'username', 'country', 'rating', 'created_at'];
        $user = User::factory()->has(UserBio::factory()->sequence(
            ['language' => 'uk'],
            ['language' => 'en'],
        )->count(2), 'bios')->create();

        $data = $user->toSearchableArray();
        foreach ($fieldsThatShouldBePresent as $key) {
            $this->assertTrue($data[$key] == $user->$key, "Key $key is not equal");
        }
        $this->assertArrayHasKey('bios', $data);
        $this->assertArrayHasKey('photo', $data);
    }
}
