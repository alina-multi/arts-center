<?php

use App\Enums\TagTypes;
use App\Jobs\RecountUserRatings;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\TagTitle;
use App\Models\User;
use App\Models\Vote;
use App\Models\Work;
use App\Models\WorkTitle;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\Fluent\AssertableJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('vote for work', function () {
    $response = doVote('work');
});

test('vote for comment', function () {
    $response = doVote('comment');
});

test('vote for feedback', function () {
    $response = doVote('feedback');
});

test('double vote', function () {
    $user = User::factory()->create();
    $work = Work::factory()->create();
    $json = [
        'vote' => 1,
        'votable_type' => 'work',
        'votable_id' => $work->id
    ];
    $this->actingAs($user)->postJson('/api2/vote', $json);
    $this->actingAs($user)->postJson('/api2/vote', $json);
    $this->assertDatabaseCount('votes', 1)
        ->assertDatabaseHas('works', ['rating' => 2]);
});

test('change vote', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create();
    $json = [
        'vote' => 1,
        'votable_type' => 'comment',
        'votable_id' => $comment->id
    ];
    $this->actingAs($user)->postJson('/api2/vote', $json);
    $this->actingAs($user)->postJson('/api2/vote', [...$json, 'vote' => -1]);
    $this->assertDatabaseCount('votes', 1)
        ->assertDatabaseHas('comments', ['rating' => 0]);
});

test('destroy vote', function () {
    $user = User::factory()->create();
    $work = Work::factory()->create();
    $json = [
        'vote' => 1,
        'votable_type' => 'work',
        'votable_id' => $work->id
    ];
    $this->actingAs($user)->postJson('/api2/vote', $json);
    $this->actingAs($user)->deleteJson('/api2/vote', $json);
    $this->assertDatabaseCount('votes', 0)
        ->assertDatabaseHas('works', ['rating' => 1]);
});

test('negative not allowed for work', function () {
    $user = User::factory()->create();
    $work = Work::factory()->create(['rating' => 1]);
    $json = [
        'vote' => -1,
        'votable_type' => 'work',
        'votable_id' => $work->id
    ];
    $this->actingAs($user)->postJson('/api2/vote', $json)->assertStatus(422);
    $this->assertDatabaseCount('votes', 0)
        ->assertDatabaseHas('works', ['rating' => 1]);
});

test('vote work tag rating', function () {
    Bus::fake();
    $user = User::factory()->create();
    $owner = User::factory()->create();
    $work = Work::factory()->create();
    $tag = Tag::factory()->create();
    TagTitle::factory(['tag_id' => $tag->id, 'title' => 'test'])->create();
    $work->tags()->attach($tag->id);
    $work->owners()->attach($owner->id);
    $json = [
        'vote' => 1,
        'votable_type' => 'work',
        'votable_id' => $work->id
    ];
    $this->actingAs($user)->postJson('/api2/vote', $json);
    Bus::assertDispatched(RecountUserRatings::class);
});

function doVote($type, $vote = 1)
{
    $class = Relation::getMorphedModel($type);
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $entity = $class::factory()->create();
    $json = [
        'vote' => $vote,
        'votable_type' => $type,
        'votable_id' => $entity->id
    ];
    $response = test()->actingAs($user)->postJson('/api2/vote', $json)
        ->assertJson(['rating' => 2]);
    test()->assertDatabaseHas(
        'votes',
        [
            'user_id' => $user->id,
            'vote' => $vote,
            'votable_type' => $type,
            'votable_id' => $entity->id
        ]
    );

    // Second vote from different user
    $response = test()->actingAs($user2)->postJson('/api2/vote', $json)
        ->assertJson(['rating' => 3]);
    test()->assertDatabaseHas(
        'votes',
        [
            'user_id' => $user2->id,
            'vote' => $vote,
            'votable_type' => $type,
            'votable_id' => $entity->id
        ]
    );
    test()->assertDatabaseHas(
        $entity->getTable(),
        [
            'rating' => 3,
        ]
    );
    return $response;
}

test('recount user ratings', function () {
    $owner = User::factory()->create();
    $work = Work::factory(['rating' => 5])->create();
    WorkTitle::factory(['work_id' => $work->id])->create();

    // This work has titles in en and ru so it should add user rating in both languages
    $work2 = Work::factory(['rating' => 3])->create();
    WorkTitle::factory(['work_id' => $work2->id])->create();
    WorkTitle::factory(['work_id' => $work2->id, 'language' => 'ru'])->create();
    $tag = Tag::factory(['type_id' => TagTypes::CATEGORY])->create();
    $tag2 = Tag::factory(['type_id' => TagTypes::CATEGORY])->create();
    $work->category()->attach($tag->id);
    $work->owners()->attach($owner->id);
    $work2->category()->attach($tag->id);
    $work2->category()->attach($tag2->id);
    $work2->owners()->attach($owner->id);
    RecountUserRatings::dispatchSync($owner->id);

    // 2 works in english with this tag 3+5 = 8
    $this->assertDatabaseHas(
        'user_ratings',
        ['ratable_type' => 'tag', 'ratable_id' => $tag->id, 'language' => 'en', 'rating' => 8]
    );

    // One work in english with this tag 3
    $this->assertDatabaseHas(
        'user_ratings',
        ['ratable_type' => 'tag', 'ratable_id' => $tag2->id, 'language' => 'en', 'rating' => 3]
    );

    // 2 works in english for this user 3+5 = 8
    $this->assertDatabaseHas(
        'user_ratings',
        ['ratable_type' => 'user', 'ratable_id' => $owner->id, 'language' => 'en', 'rating' => 8]
    );

    // 1 work in russian for this user 3
    $this->assertDatabaseHas(
        'user_ratings',
        ['ratable_type' => 'user', 'ratable_id' => $owner->id, 'language' => 'ru', 'rating' => 3]
    );
});
