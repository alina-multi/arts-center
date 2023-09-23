<?php

use App\Models\Work;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('to searchable array', function () {
    $work = Work::factory()->convertedImages()->has(\App\Models\WorkTitle::factory()->sequence(
        ['language' => 'uk'],
        ['language' => 'en'],
    )->count(2), 'titles')->create();

    $owner = \App\Models\User::factory()->create();
    $work->owners()->attach($owner);
    $work->load('owners', 'owners.photo', 'owners.photo.variants');

    $data = $work->toSearchableArray();
    expect($data)->toBe([
        'id' => $work->id,
        'published_at' => $work->published_at->toDateTimeString(),
        'rating' => (int)$work->rating,
        'comments' => (int)$work->comments,
        'hosts' => (int)$work->hosts,
        'price' => (int)$work->price,
        'titles' => $work->titles->map(fn($title) => [
            'language' => $title->language,
            'title' => $title->title,
            'description' => $title->description,
            'alt' => $title->alt,
            'colors' => $title->colors,
        ])->toArray(),
        'preview' => $work->preview->toArray(),
        'owners' => $work->owners->map(fn(\App\Models\User $owner) => [
            'id' => $owner->id,
            'name' => $owner->name,
            'username' => $owner->username,
            'created_at' => $owner->created_at->toISOString(),
            'premium' => $owner->premium,
            'photo' => $owner->photo->toArray()
        ])->toArray()
    ]);
});
