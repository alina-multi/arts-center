<?php

use App\Enums\TagTypes;
use App\Models\Tag;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\{actingAs, assertDatabaseHas};


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('create draft', function () {
    Storage::fake('s3');
    $images = [
        'temp/works/1_1.jpeg',
        'temp/works/1_2.jpeg',
        'temp/works/1_3.jpeg',
    ];
    $testFile = UploadedFile::fake()->image("test.jpeg", 1600, 1600);
    foreach ($images as $image) {
        Storage::disk('s3')->putFileAs('', $testFile, $image);
    }
    $user = User::factory()->create();

    actingAs($user)->postJson('/api2/draft', [
        'main' => array_shift($images),
        'more' => $images,
        'language' => 'en',
    ])->assertStatus(201)
        ->assertJson(fn(AssertableJson $json) => $json->where('id', 1)
            ->has('owners', 1)
            ->has('images', 2)
            ->has('titles', 1)
            ->has('full', 3)
            ->etc()
        );
});

test('edit draft', function () {
    Bus::fake();
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $categories = Tag::factory(
        [
            'type_id' => TagTypes::CATEGORY
        ]
    )->count(2)->create();
    $tag = Tag::factory(['type_id' => TagTypes::TAG])->create();
    $categoryIds = $categories->pluck('id');
    $tagIds = [$tag->id];
    $work = Work::factory([
        'published_at' => null,
        'show_uk' => false,
        'show_en' => false,
        'price' => 0,
        'rating' => 0,
        'comments' => 0
    ])
        ->has(\App\Models\WorkTitle::factory()->sequence(['language' => 'uk'], ['language' => 'en']), 'titles')
        ->create();
    $work->owners()->attach($user);

    actingAs($otherUser)->putJson("/api2/draft/$work->id")
        ->assertStatus(403);

    // Category and language is required
    actingAs($user)->putJson("/api2/draft/$work->id", [
        'title' => 'test title',
    ])->assertInvalid(['category', 'language']);

    // tags shouldn't be allowed
    actingAs($user)->putJson("/api2/draft/$work->id", [
        'title' => 'test',
        'category' => [...$categoryIds, ...$tagIds]
    ])->assertInvalid('category.2');

    // title is too short
    actingAs($user)->putJson("/api2/draft/$work->id", [
        'title' => 't',
        'category' => $categoryIds
    ])->assertInvalid('title');

    //If crop is set, all fields should be there
    actingAs($user)->putJson("/api2/draft/$work->id", [
        'title' => 'test',
        'category' => $categoryIds,
        'crop' => [
            'height' => 450,
            'y' => 75
        ]
    ])->assertInvalid(['crop.x', 'crop.width']);

    //AspectRatio validator, should be 4/3
    actingAs($user)->putJson("/api2/draft/$work->id", [
        'title' => 'test',
        'category' => $categoryIds,
        'crop' => [
            'width' => 600,
            'height' => 400,
            'x' => 0,
            'y' => 75
        ]
    ])->assertInvalid('crop.height');

    $validStringButWithHtml = '<b>Valid but with html</b>';
    actingAs($user)->putJson("/api2/draft/$work->id", [
        'language' => 'uk',
        'title' => $validStringButWithHtml,
        'description' => $validStringButWithHtml,
        'category' => $categoryIds,
        'crop' => [
            'width' => 600,
            'height' => 450,
            'x' => 0,
            'y' => 75
        ]
    ])->assertValid();

    Bus::assertDispatched(\App\Jobs\CropWorkImage::class);

    assertDatabaseHas('work_titles', [
        'title' => strip_tags($validStringButWithHtml),
        'description' => strip_tags($validStringButWithHtml),
        'language' => 'uk'
    ]);

    expect(sizeof($categoryIds))->toEqual($work->category()->count());
});

test('get draft', function () {
    $user = User::factory()->create();
    $work = Work::factory()->hasTitles()->create();
    $work->owners()->attach($user);
    actingAs($user)->getJson("/api2/draft/$work->id")
        ->assertStatus(200);
});

test('publish draft', function () {
    Bus::fake();
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $work = Work::factory()->hasTitles()->create(['published_at' => null]);
    $work->owners()->attach($user);
    actingAs($otherUser)->putJson("/api2/draft/$work->id/publish", [
        'published_at' => '2033-12-12'
    ])->assertForbidden();
    actingAs($user)->putJson("/api2/draft/$work->id/publish", [
        'published_at' => '2033-12-12'
    ])->assertNoContent();
    $this->assertDatabaseHas('works', [
        'id' => $work->id,
        'published_at' => '2033-12-12 00:00:00',
        'status' => \App\Enums\WorkStatuses::USER_PUBLISHED
    ]);
    Bus::assertDispatched(\App\Jobs\TranslateWork::class);
    Bus::assertDispatched(\App\Jobs\ConvertImage::class);
});

test('move to draft', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $work = Work::factory()->hasTitles()->create();
    $work->owners()->attach($user);
    actingAs($otherUser)->deleteJson("/api2/draft/$work->id/draft")->assertForbidden();
    actingAs($user)->deleteJson("/api2/draft/$work->id/draft")->assertNoContent();
    $this->assertDatabaseHas('works', [
        'id' => $work->id,
        'published_at' => null,
        'status' => \App\Enums\WorkStatuses::DRAFT
    ]);
});

test('delete draft', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $work = Work::factory()->hasTitles()->create();
    $work->owners()->attach($user);
    actingAs($otherUser)->deleteJson("/api2/draft/$work->id")->assertForbidden();
    // Published work can not be deleted
    actingAs($user)->deleteJson("/api2/draft/$work->id")->assertForbidden();
    $work->published_at = null;
    $work->save();
    actingAs($user)->deleteJson("/api2/draft/$work->id")->assertNoContent();
    $this->assertDatabaseHas('works', [
        'id' => $work->id,
        'deleted_at' => now(),
        'status' => \App\Enums\WorkStatuses::DELETED,
    ]);
});
