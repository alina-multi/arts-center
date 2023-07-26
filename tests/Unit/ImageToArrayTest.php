<?php

use App\Enums\ImageFolders;
use App\Models\Image;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('to searchable array', function () {
    $image = Image::factory()->create(['folder' => ImageFolders::Preview]);
    $result = $image->toArray();
    expect($result)->toEqual([
        "src" => "preview/1.jpeg",
        "sources" => [
            [
                "type" => "image/jpeg",
                "srcset" => "preview/1.jpeg 300w, preview/2.jpeg 600w"
            ],
            [
                "type" => "image/webp",
                "srcset" => "preview/3.webp 300w, preview/4.webp 600w"
            ],
        ],
        "original" => [
            "src" => "preview/5.jpeg",
            "width" => 1024,
            "height" => 768
        ]
    ]);
});
