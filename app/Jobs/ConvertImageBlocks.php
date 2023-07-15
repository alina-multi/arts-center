<?php

namespace App\Jobs;

use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ConvertImageBlocks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $works;

    public function __construct(protected Collection $blocks)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->blocks->sortBy('order') as $block) {
            $work = $this->getWork($block->work_id);
            if ($block->type === 'image') {
                $image = $block?->images?->first();
                if (!$image) {
                    continue;
                }
                if ($work->full_image_id) {
                    $work->images()->attach($image);
                } else {
                    $work->full_image_id = $image->id;
                }
            }
            if ($block->type === 'grid') {
                foreach ($block->images as $image) {
                    $work->images()->attach($image);
                }
            }
        }

        foreach ($this->works as $work) {
            $work->save();
        }
    }

    public function getWork($id)
    {
        if (empty($this->works[$id])) {
            $this->works[$id] = Work::firstWhere('id', $id);
        }
        return $this->works[$id];
    }
}
