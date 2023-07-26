<?php

use App\Jobs\ConvertImageBlocks;
use App\Models\Work;
use App\Models\WorkBlock;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('converting', function () {
    $work = Work::factory([
        'full_image_id' => null
    ])->create();
    $imageBlocks = WorkBlock::factory([
        'work_id' => $work->id,
        'language' => 'zz',
        'type' => 'image',
    ])->hasImages(1)
        ->count(2)->create();

    $gridBlocks = WorkBlock::factory([
        'work_id' => $work->id,
        'language' => 'zz',
        'type' => 'grid',
    ])->hasImages(2)
        ->count(2)->create();

    ConvertImageBlocks::dispatch($work->blocks);

    $this->assertDatabaseHas('works', [
        'full_image_id' => $imageBlocks[0]->images[0]->id
    ]);
    expect(5)->toEqual($work->images->count(), "There should have bean 11 images 2*2 grids + 1 extra image");
});
