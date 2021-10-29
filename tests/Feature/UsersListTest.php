<?php

namespace Tests\Feature;

use App\Tag;
use App\TagTitle;
use App\User;
use App\UserRatings;
use App\Work;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class UsersListTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $users = $this->createUsers([1, 5, 2, 0]);
        $response = $this->getJson('api/user');
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('users', 3) // Last one has rating 0, so shouldn't be displayed here
            // Second user, has the biggest rating and should be returned first
            ->has('users.0', fn($json) => $json->where('id', $users[1]['user']->id)
                ->where('name', $users[1]['user']->name)
                ->missing('password')
                ->etc()
            )->etc()
        );
    }

    public function testTag()
    {
        $tag = 'test';
        // Couple with different tag shouldn't appear in result
        $this->createUsers([1, 5], 'somethingElse');
        $users = $this->createUsers([1, 5, 2, 0], $tag);
        $response = $this->getJson('api/user?tag=' . $tag);
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('users', 3) // Last one has rating 0, so shouldn't be displayed here
            // Second user, has the biggest rating and should be returned first
            ->has('users.0', fn($json) => $json->where('id', $users[1]['user']->id)
                ->where('name', $users[1]['user']->name)
                ->missing('password')
                ->etc()
            )->etc()
        );
    }

    public function testNew()
    {
        $this->createUsers([7, 15], 'tag');
        $users2 = $this->createUsers([1, 0, null], 'tag2');
        $response = $this->getJson('api/user?order=new');
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('users', 5) // Including both tags and 0 and no rating at all
            ->has('users.0',
                fn($json) => $json->where(
                    'id',
                    $users2[2]['user']->id
                ) // Now the last added should be first even if he has rating 0
                ->where('name', $users2[2]['user']->name)
                    ->missing('password')
                    ->etc()
            )->etc()
        );
    }

    public function testNewForTag()
    {
        $this->createUsers([7, 15, 44], 'tag');
        $users2 = $this->createUsers([1, 0, null, 5], 'tag2');
        $response = $this->getJson('api/user?order=new&tag=tag2');
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('users', 2) // Should not include 0 and null rating
            ->has('users.0',
                fn($json) => $json->where(
                    'id',
                    $users2[3]['user']->id
                ) // Last one with positive rating
                ->where('name', $users2[3]['user']->name)
                    ->missing('password')
                    ->etc()
            )->etc()
        );
    }

    public function testCountry()
    {
        $this->createUsers([1, 5], 'all', ['country' => 'de']);
        $users = $this->createUsers([1, 5, 2, 0], 'all', ['country' => 'ua']);
        $response = $this->getJson('api/user?country=ua');
        $response->assertJson(
        // Users from different country and with 0 rating should be ignored
            fn(AssertableJson $json) => $json->has(
                'users',
                3
            )
                // Second user, has the biggest rating and should be returned first
                ->has('users.0', fn($json) => $json->where('id', $users[1]['user']->id)
                    ->where('name', $users[1]['user']->name)
                    ->missing('password')
                    ->etc()
                )->etc()
        );
    }

    public function testUserWorks()
    {
        $users = $this->createUsers([1, 5, 2, 0]);
        $this->createWorksForUsers($users);
        $response = $this->getJson('api/user');
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('users', 3) // Last one has rating 0, so shouldn't be displayed here
            // Second user, has the biggest rating and should be returned first
            ->has('users.0', fn($json) => $json->where('id', $users[1]['user']->id)
                ->where('name', $users[1]['user']->name)
                ->missing('password')
                ->etc()
            )->etc()
        );
    }

    public function createUsers(array $ratings, string $tag = 'all', array $userFactory = [])
    {
        $returnUsers = [];
        if ($tag !== 'all') {
            $tagModel = Tag::factory()->create();
            $tagId = $tagModel->id;
            TagTitle::factory(['tag_id' => $tagId, 'title' => $tag])->create();
        }
        foreach ($ratings as $rating) {
            $user = User::factory($userFactory)->create();
            if ($rating !== null) {
                UserRatings::factory([
                                         'user_id' => $user->id,
                                         'ratable_type' => $tag === 'all' ? 'user' : 'tag',
                                         'ratable_id' => $tagId ?? $user->id,
                                         'rating' => $rating
                                     ])->create();
            }
            $returnUsers[] = ['user' => $user, 'rating' => $rating];
        }
        return $returnUsers;
    }

    public function createWorksForUsers($users, $count = 3, $workFactory = [])
    {
        foreach ($users as $user) {
            for ($i = 1; $i <= $count; $i++) {
                $work = Work::factory(['rating' => $i] + $workFactory)->create();
                $work->owners()->attach($user['user']->id);
            }
        }
    }
}
