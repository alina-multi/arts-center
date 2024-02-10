<?php

namespace App\Console\Commands;

use App\Console\Traits\getNewUserId;
use App\Models\Image;
use App\Jobs\DownloadAndSaveImage;
use App\Models\Tag;
use App\Models\User;
use App\Models\WorkBlock;
use App\Models\WorkDescription;
use App\Models\WorkDetails;
use App\Models\WorkTitle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Work;

class UploadWorks extends Command
{
    use getNewUserId;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:works';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload works that fail for some reason';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::connection('old')->table('gallery')
            ->orderBy('id', 'DESC')
            ->select('id', 'img', 'user')
            ->chunk(200, function ($oldWorks) {
                foreach ($oldWorks as $oldWork) {
                    $userId = $this->getNewUserId($oldWork->user);
                    // Big one first, second is fallback
                    $oldPhotoUrl = [
                        "https://i.arts.in.ua/i/f_$oldWork->user/$oldWork->img.jpg",
                        "https://i.arts.in.ua/i/$oldWork->user/$oldWork->img.jpg"
                    ];
                    $work = Work::where('old_id', $oldWork->id)->first();
                    if ($work && $work->image_id > 0) { //Skip if this one is already uploaded
                        print "Skipping $oldWork->id it already has image uploaded \n";
                        continue;
                    }

                    if ($work) {
                        $imageWorkBlock = WorkBlock::where('work_id', $work->id)->where('type', 'image')->first();
                        if ($imageWorkBlock) {
                            DownloadAndSaveImage::dispatch('works', $userId, $oldPhotoUrl, $oldWork->img . '.jpg', [$work, $imageWorkBlock]);
                            print "Scheduling upload for $oldWork->id new user id is: $userId \n";
                        } else {
                            print "Can't find image block associated with $oldWork->id new user id is: $userId \n";
                        }
                    } else {
                        print "Can't find work associated with $oldWork->id new user id is: $userId \n";
                    }
                }
            });
    }
}
