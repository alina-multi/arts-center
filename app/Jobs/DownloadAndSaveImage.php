<?php

namespace App\Jobs;

use App\Helpers\ImageHelper;
use App\Models\User;
use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DownloadAndSaveImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public string $folder, $filename;
    public array $attachModels, $url;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($folder, $user, $url, $filename, $attachModels = [])
    {
        $this->user = $user;
        // If we get string, convert it to 1 element array
        $this->url = is_array($url) ? $url : [$url]; ;
        $this->filename = $filename;
        $this->folder = $folder;
        $this->attachModels = $attachModels;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // If we get ID instead of User model get it now
        if (is_int($this->user)) {
            $this->user = User::where('id', $this->user)->first();
        }
        //Get the first available image
        foreach ($this->url as $url) {
            $photo = @file_get_contents($url);
            if (!empty($photo)) {
                $extension = pathinfo($url, PATHINFO_EXTENSION);
                break;
            }
        }

        if ($photo) {
            $image = ImageHelper::upload($this->folder, $photo, $this->filename, $extension, $this->user->id);
            $this->user->images()->syncWithoutDetaching([$image->id]);
            if ($this->folder == 'photos') {
                $this->user->image_id = $image->id;
                $this->user->save();
            }
            foreach ($this->attachModels as $model) {
                // Attach directly if it has image_id
                if (in_array(get_class($model), [Work::class])) {
                    Log::info(get_class($model). 'image_id block');
                    $model->image_id = $image->id;
                    $model->save();
                } else { // Or attach via imageables
                    Log::info(get_class($model). 'sync block');
                    $model->images()->attach([$image->id]);
                }
            }
        }
    }
}
