<?php

namespace App\Jobs;

use App\Models\WorkTitle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertTextBlocks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workTitles = [];

    public function __construct(protected $blocks)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->blocks as $block) {
            $workTitle = $this->getWorkTitle($block->work_id, $block->language);
            $text = $this->simpleDeltaParse($block->data);
            // If it's not empty let's separate by 2 line brakes
            if ($workTitle->description) {
                $workTitle->description.="\n\n";
            }
            $workTitle->description.=$text;
            $workTitle->description=trim($workTitle->description);
        }

        foreach ($this->workTitles as $workGroup) {
            foreach ($workGroup as $title) {
                $title->save();
            }
        }
    }

    protected function getWorkTitle($work_id, $language)
    {
        if (!empty($this->workTitles[$work_id][$language])) {
            return $this->workTitles[$work_id][$language];
        }
        return $this->workTitles[$work_id][$language] = WorkTitle::firstOrNew([
            'work_id' => $work_id,
            'language' => $language
        ]);
    }

    protected function simpleDeltaParse($data) {
        $strings = [];
        if (!empty($data['text'])) {
            return $data['text'];
        }
        if (empty($data['ops']) or !is_array($data['ops'])) {
            return '';
        }
        foreach ($data['ops'] as $op) {
            if (!empty($op['insert']) && is_string($op['insert'])) {
                $strings[] = $op['insert'];
            }
        }
        return join("\n\n",$strings);
    }
}
