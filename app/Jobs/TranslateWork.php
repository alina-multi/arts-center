<?php

namespace App\Jobs;

use App\WorkTitle;
use Google\Cloud\Translate\V2\TranslateClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\ResponseCache\Facades\ResponseCache;

class TranslateWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $work;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($work)
    {
        $this->work = $work;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $translate = new TranslateClient(['keyFilePath' => '/var/www/config/google.json']);
        $languages = ['ru', 'en', 'uk'];
        $alreadyTranslated = [];
        foreach ($this->work->titles as $title) {
            $alreadyTranslated[] = $title->language;
            // We don't really have a preference which one to use so just the last one
            $lastTitle = $title->title;
        }
        if ($lastTitle) {
            $missingLanguages = array_diff($languages, $alreadyTranslated);
            if (sizeof($missingLanguages)) {
                foreach ($missingLanguages as $targetLanguage) {
                    $translated = $translate->translate($lastTitle, [
                        'target' => $targetLanguage,
                    ]);
                    if ($translated) {
                        $newTitle = WorkTitle::create([
                                              'language' => $targetLanguage,
                                              'title' => mb_substr(htmlspecialchars_decode($translated['text']), 0, 30),
                                              'work_id' => $this->work->id
                                          ]);
                        if ($newTitle) {
                            $field = 'show_' . $targetLanguage;
                            $this->work->$field;
                        }
                    }
                }
            }
            $this->work->save();
            ResponseCache::clear(['gallery', 'work']);
        }
    }
}
