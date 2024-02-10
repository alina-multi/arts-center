<?php

use App\Models\User;
use App\Models\UserBio;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('to searchable array', function () {
    $fieldsThatShouldBePresent = ['id', 'name', 'email', 'username', 'country', 'rating', 'created_at'];
    $user = User::factory()->has(UserBio::factory()->sequence(
        ['language' => 'uk'],
        ['language' => 'en'],
    )->count(2), 'bios')->create();

    $data = $user->toSearchableArray();
    foreach ($fieldsThatShouldBePresent as $key) {
        expect($data[$key] == $user->$key)->toBeTrue();
    }
    expect($data)->toHaveKey('bios');
    expect($data)->toHaveKey('photo');
});
