<?php
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

use \App\Models\{User, Work, Favorite, FavoriteFolder};
use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseMissing, getJson};

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->work = Work::factory()->create();
    $this->folder = FavoriteFolder::factory()->create([
        'user_id' => $this->user->id,
    ]);
});

test('Add and create folder', function () {
    actingAs($this->user)->postJson('/api2/favorite', [
        'folder_title' => $this->folder->title
    ])->assertInvalid(['folder_title', 'work_id']);

    actingAs($this->user)->postJson('/api2/favorite', [
        'work_id' => $this->work->id,
        'folder_title' => 'some title'
    ])->assertCreated();

    assertDatabaseHas('favorites', [
        'work_id' => $this->work->id,
        'user_id' => $this->user->id,
        'favorite_folder_id' => $this->folder->id + 1
    ]);

    assertDatabaseHas('favorite_folders', [
        'title' => 'some title'
    ]);
});

test('Add to existing folder', function () {
    actingAs($this->user)->postJson('/api2/favorite', [
        'folder_id' => 999
    ])->assertInvalid(['folder_id', 'work_id']);

    actingAs($this->user)->postJson('/api2/favorite', [
        'folder_id' => $this->folder->id,
        'work_id' => $this->work->id
    ])->assertCreated();

    assertDatabaseHas('favorites', [
        'work_id' => $this->work->id,
        'user_id' => $this->user->id,
        'favorite_folder_id' => $this->folder->id
    ]);
});

test('Remove', function () {
    actingAs($this->user)->deleteJson('/api2/favorite', [
        'folder_id' => 999
    ])->assertInvalid(['folder_id', 'work_id']);

    actingAs($this->user)->deleteJson('/api2/favorite', [
        'folder_id' => $this->folder->id,
        'work_id' => $this->work->id
    ])->assertNotFound();

    Favorite::create([
        'favorite_folder_id' => $this->folder->id,
        'work_id' => $this->work->id,
        'user_id' => $this->user->id
    ]);

    actingAs($this->user)->deleteJson('/api2/favorite', [
        'folder_id' => $this->folder->id,
        'work_id' => $this->work->id
    ])->assertOk();

    assertDatabaseMissing('favorites', [
        'work_id' => $this->work->id
    ]);
});

test('Rename folder', function () {
    $wrongUser = User::factory()->create();
    $url = "/api2/favorite-folder/{$this->folder->id}";
    actingAs($wrongUser)->putJson($url, [
        'title' => 'new title'
    ])->assertForbidden();

    actingAs($this->user)->putJson($url, [
        'title' => 'new title'
    ])->assertOk();

    assertDatabaseHas('favorite_folders', [
        'title' => 'new title'
    ]);
});

test('Destroy folder', function () {
    $wrongUser = User::factory()->create();
    $url = "/api2/favorite-folder/{$this->folder->id}";
    actingAs($wrongUser)->deleteJson($url)->assertForbidden();

    $favorite = Favorite::create([
        'user_id' => $this->user->id,
        'work_id' => $this->work->id,
        'favorite_folder_id' => $this->folder->id
    ]);
    // We shouldn't be able to delete non-empty folders
    actingAs($this->user)->deleteJson($url)->assertUnprocessable();
    $favorite->delete();

    actingAs($this->user)->deleteJson($url)->assertOk();

    assertDatabaseMissing('favorite_folders', [
        'id' => $this->folder->id
    ]);
});

test('Get folders', function () {
    actingAs($this->user)->getJson('/api2/favorite-folder')->assertJson([
        [
            'id' => $this->folder->id,
            'title' => $this->folder->title
        ]
    ]);
});

test('Get works from folder', function () {
    $wrongUser = User::factory()->create();
    Favorite::create([
        'user_id' => $this->user->id,
        'work_id' => $this->work->id,
        'favorite_folder_id' => $this->folder->id
    ]);

    actingAs($wrongUser)->getJson("/api2/favorite-folder/{$this->folder->id}")->assertForbidden();

    actingAs($this->user)->getJson("/api2/favorite-folder/{$this->folder->id}")->assertJson(function (\Illuminate\Testing\Fluent\AssertableJson $json) {
        $json->has('works', 1)
            ->where('id', $this->folder->id)
            ->where('title', $this->folder->title);
    });

});
