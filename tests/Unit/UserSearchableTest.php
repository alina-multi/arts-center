<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserBio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSearchableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
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
        // We assume this from the factory data database/factories/UserFactory.php:32
        $this->assertTrue($data['photo']['src'] === 'photos/2.jpeg' );
        $this->assertTrue($data['photo']['srcset'] === 'photos/2.jpeg 300w, photos/3.jpeg 600w' );
        $this->assertTrue(sizeof($data['photo']['sources']) === 5 );
        $this->assertArrayHasKey('bios', $data);
    }
}
