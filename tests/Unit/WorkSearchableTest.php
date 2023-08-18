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
    $work->load('owners', 'owners.photo');

    $data = $work->toSearchableArray();
    expect($data)->toBe([
        'id' => $work->id,
        'published_at' => $work->published_at->toString(),
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
        'image' => $work->image->toArray(),
        'owners' => $work->owners->toArray()
    ]);
});
