<?php

namespace App\Console\Commands;

use App\Console\Traits\getNewUserId;
use App\Image;
use App\Jobs\DownloadAndSaveImage;
use App\Tag;
use App\User;
use App\WorkBlock;
use App\WorkDescription;
use App\WorkDetails;
use App\WorkTitle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Work;

class ConvertWorks extends Command
{
    use getNewUserId;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:works {--clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert from old gallery table to new works table';

    protected $languages = ['ru', 'en', 'de', 'fr'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('clear')) {
            foreach (['images','ownables', 'taggables', 'works', 'work_blocks', 'work_details', 'work_titles', 'imageables'] as $table) {
                DB::table($table)->truncate();
            }
        }
        $oldArtToTags = Tag::where('type_id', 1)->get()->keyBy('old_id');
        $now = date('Y-m-d H:i:s');
        $idsAllreadyInDb = Work::get()->pluck('old_id')->toArray();
        DB::connection('old')->table('gallery')
            ->orderBy('id', 'ASC')
            ->select('id', 'img', 'art', 'user', 'title', 'technique', 'year', 'desc', 'added', 'price', 'size', 'rate', 'hosts', 'en_title', 'de_title', 'fr_title', 'en_desc', 'de_desc', 'fr_desc', 'en_technique', 'de_technique', 'fr_technique')
            ->whereNotIn('id', $idsAllreadyInDb)->chunk(50, function ($oldWorks) use ($now, $oldArtToTags) {
                foreach ($oldWorks as $oldWork) {
                    $order = 0; //For work blocks

                    $userId = $this->getNewUserId($oldWork->user);
                    if (empty($userId) || empty($oldWork->img)) { //Do we have everything we need?
                        print "wtf $oldWork->user : $userId \n";
                        continue;
                    }
                    // Big one first, second is fallback
                    $oldPhotoUrl = [
                        "https://i.arts.in.ua/i/f_$oldWork->user/$oldWork->img.jpg",
                        "https://i.arts.in.ua/i/$oldWork->user/$oldWork->img.jpg"
                    ];

                    $work = Work::create([
                        'image_id' => 0, // Will be replaced in job later once uploaded
                        'rating' => $oldWork->rate,
                        'price' => $oldWork->price,
                        'created_at' => $oldWork->added,
                        'old_id' => $oldWork->id,
                        'hosts' => $oldWork->hosts,
                        'published_at' => $oldWork->added
                    ]);

                    // First add image to blocks with ho margin by default, it would be on top
                    $imageWorkBlock = WorkBlock::create([
                        'work_id' => $work->id,
                        'created_at' => $work->created_at,
                        'language' => 'zz', //Special code for all languages
                        'type' => 'image',
                        'order' => $order++,
                        'data' => [
                            'margin' => 0 //There would be mode for blocks with and without margin
                        ]
                    ]);

                    DownloadAndSaveImage::dispatch('works', $userId, $oldPhotoUrl, $oldWork->img . '.jpg', [$work, $imageWorkBlock]);

                    // Now add additional images as a block (if there are some)
                    $fragments = DB::connection('old')->table('fragments')->where('parent', $oldWork->id)->get();
                    if (!$fragments->isEmpty()) {
                        $fragmentsJson = [];

                        $gridWorkGrid = WorkBlock::create([
                            'work_id' => $work->id,
                            'created_at' => $work->created_at,
                            'language' => 'zz', //Special code for all languages
                            'type' => 'grid',
                            'order' => $order++,
                            'data' => [
                                'margin' => 0 //There would be mode for blocks with and without margin
                            ]
                        ]);
                        foreach ($fragments as $fragment) {
                            $fragmentName =  $oldWork->id . '.' . $fragment->id . '.jpg';
                            $oldFragmentUrl = "https://i.arts.in.ua/i/$oldWork->user/$fragmentName";
                            DownloadAndSaveImage::dispatch('grids', $userId, $oldFragmentUrl, $fragmentName, [$gridWorkGrid]);
                        }
                    }


                    $work->owners()->attach($userId);

                    //Add tag for art
                    if ($oldWork->art) {
                        $work->tags()->attach($oldArtToTags[$oldWork->art]);
                        $oldArtToTags[$oldWork->art]->count++;
                    }

                    //Titles for all languages
                    foreach ($this->languages as $lang) {
                        $fieldName = $this->getLanguagePrefix($lang) . 'title';
                        if (!empty($oldWork->$fieldName)) {
                            $workTitle = WorkTitle::create([
                                'title' => mb_substr($oldWork->$fieldName, 0, 30),
                                'work_id' => $work->id,
                                'created_at' => $work->created_at,
                                'language' => $lang
                            ]);
                        }
                    }

                    //Descriptions and technique for all languages to text blocks
                    foreach ($this->languages as $lang) {
                        foreach (['technique', 'desc'] as $oldFieldType) {
                            $fieldName = $this->getLanguagePrefix($lang) . $oldFieldType;
                            if (!empty($oldWork->$fieldName)) {
                                WorkBlock::create([
                                    'work_id' => $work->id,
                                    'created_at' => $work->created_at,
                                    'language' => $lang,
                                    'type' => 'text',
                                    'order' => $order++,
                                    'data' => ['text' => $oldWork->$fieldName]
                                ]);
                            }
                        }
                    }

                    $dimensions = $this->splitDimensions($oldWork->size);

                    WorkDetails::create(
                        array_merge([
                            'work_id' => $work->id,
                            'year' => $oldWork->year
                        ], $dimensions)
                    );

                    print "$oldWork->title new user id is: $userId \n";

                }
                //Save category count
                foreach ($oldArtToTags as $tag) {
                    $tag->save();
                }
            });
    }

    public function getLanguagePrefix($language)
    {
        if ($language == 'ru') {
            return '';
        } else {
            return $language . '_';
        }
    }

    public function splitDimensions($string)
    {
        if (!$string) return [];
        $dimensions = preg_split("/[\D,]+/", trim($string));

        if (sizeof($dimensions) > 1 && sizeof($dimensions) < 4) { // We need 2-3 numbers
            return [
                'width' => empty($dimensions[0]) ? null : $dimensions[0],
                'height' => empty($dimensions[1]) ? null : $dimensions[1],
                'length' => empty($dimensions[2]) ? null : $dimensions[2]
            ];
        } else {
            return [];
        }
    }
}
