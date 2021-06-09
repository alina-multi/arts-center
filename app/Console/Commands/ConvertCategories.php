<?php

namespace App\Console\Commands;

use App\Tag;
use App\TagTitle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Google\Cloud\Translate\V2\TranslateClient;

class ConvertCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:cat  {--clear}';

    protected $languages = ['en', 'ru', 'uk', 'de', 'fr'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('clear')) {
            foreach (['tags','tag_titles'] as $table) {
                DB::table($table)->truncate();
            }
        }
        $translate = new TranslateClient([
            'keyFilePath' => '/var/www/config/google.json'
        ]);
        $art = DB::connection('old')->table('art')
            ->select('name as ru_name', 'en_name', 'id')
            ->get()->toArray();
        foreach ($art as $item) {
            if ($item->id === 0) continue;
            $tag = Tag::create(['type_id' => 1, 'old_id'=> $item->id]);
            foreach ($this->languages as $language) {
                if (!empty($item->{$language . '_name'})) {
                    $title = mb_strtolower($item->{$language . '_name'});
                    $title = preg_replace('/[^\w ]/u', '', $title);
                    $tag->titles()->create(['language' => $language, 'title' => $title]);
                } else {
                    $translation = $translate->translate($item->ru_name, [
                        'target' => $language
                    ]);
                    if ($translation['text']) {
                        $title = mb_strtolower($translation['text']);
                        $title = preg_replace('/[^\w ]/u', '', $title);
                        $tag->titles()->create(['language' => $language, 'title' => $title]);
                    }
                }
            }
        }
    }
}
