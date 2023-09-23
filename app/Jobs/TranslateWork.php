<?php

namespace App\Jobs;

use App\Events\WorkTranslated;
use App\Models\Work;
use App\Models\WorkTitle;
use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Work $work, public $sourceLanguage = '')
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $translate = new TranslateClient(['keyFile' => json_decode(env('GOOGLE'), true)]);
        $languages = ['en', 'uk'];
        $alreadyTranslated = $this->work->titles->pluck('language')->toArray();
        // Get selected language or first one
        $source = $this->sourceLanguage
            ? $this->work->titles->where('language', $this->sourceLanguage)->first()
            : $this->work->titles->first();
        if ($source) {
            $missingLanguages = array_diff($languages, $alreadyTranslated);
            if (sizeof($missingLanguages)) {
                foreach ($missingLanguages as $targetLanguage) {
                    $condition = [
                        'language' => $targetLanguage,
                        'work_id' => $this->work->id
                    ];
                    $translated = [];
                    $translated['title'] = $translate->translate($source->title, [
                        'target' => $targetLanguage,
                    ])['text'];
                    if ($source->description) {
                        $translated['description'] = $translate->translate($source->description, [
                            'target' => $targetLanguage,
                        ])['text'];
                    }
                    if ($translated) {
                        WorkTitle::updateOrCreate($condition, $translated);
                        $field = 'show_' . $targetLanguage;
                        $this->work->$field = 1;
                    }
                }
            }
            $this->work->save();
            WorkTranslated::dispatch($this->work);
        }
    }
}
