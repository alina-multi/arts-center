<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ConvertImageBlocks;
use App\Models\Work;
use App\Models\WorkBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvertImageBlocksTest extends TestCase
{
    use RefreshDatabase;

    public function testConverting(): void
    {
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
        $this->assertEquals($work->images->count(), 5, "There should have bean 11 images 2*2 grids + 1 extra image");
    }
}
