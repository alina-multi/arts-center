<?php

namespace App\Console\Commands;

use App\Jobs\ValidateWork;
use App\Models\Image;
use App\Models\Work;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RelinkWorkImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:relink-work-images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Work::where('image_id', 0)
            ->whereNotNull('old_id')
            ->chunkById(1000, function (Collection $works) {
                $relinkedInThisBatch = 0;
                $works->map(function (Work $work) use (&$relinkedInThisBatch) {
                    $oldWork = DB::connection('old')->table('gallery')->where('id', $work->old_id)->first();
                    if ($oldWork->img) {
                        $image = Image::where('name', 'like', "$oldWork->img-%")->first();
                        if ($image) {
                            $work->update([
                                'image_id' => $image->id,
                                'full_image_id' => $image->id
                            ]);
                            ValidateWork::dispatch($work);
                            $relinkedInThisBatch++;
                        }
                    }
                });
                $this->line("Batch processed fixed $relinkedInThisBatch out of 1000 last work id: {$works->last()->id}");
            });
    }
}
