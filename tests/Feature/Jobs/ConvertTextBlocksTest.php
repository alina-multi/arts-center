<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ConvertImageToVariants;
use App\Jobs\ConvertTextBlocks;
use App\Models\ImageVariant;
use App\Models\Work;
use App\Models\WorkBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Image;

class ConvertTextBlocksTest extends TestCase
{
    use RefreshDatabase;

    public function testConverting(): void
    {
        $work = Work::factory()->has(
            WorkBlock::factory([
                'work_id' => 1,
                'language' => 'uk',
                'type' => 'text'
            ])->sequence(
                [
                    'data' => json_decode('{"ops": [{"insert": "Жнива посеред війни", "attributes": {"bold": true}}, {"insert": "акварель 2023.07.10_ 38х42см\nарх. Кудлай"}]}'),
                    'order' => 0
                ],
                [
                    'data' => json_decode('{"ops": [{"insert": {"image": "https://static.xx.fbcdn.net/images/emoji.php/v9/t8b/1.5/16/1f1fa_1f1e6.png"}, "attributes": {"alt": "??", "width": "16", "height": "16"}}, {"insert": null}]}'),
                    'order' => 1
                ]
            )->count(2)
            , 'blocks')->create();
        ConvertTextBlocks::dispatch($work->blocks);
        $this->assertDatabaseHas('work_titles', ['description' => "Жнива посеред війни\n\nакварель 2023.07.10_ 38х42см\nарх. Кудлай"])
            ->assertDatabaseCount('work_titles', 1);
    }
}
