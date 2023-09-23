<?php

namespace App\Console\Commands;

use App\Helpers\ImageHelper;
use App\Jobs\DownloadAndSaveImage;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;

class ConvertAvatars extends Command
{
    protected $signature = 'convert:avatars';
    protected $description = 'Download avatars and save them on s3';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Todo: attach default avatar so it wouldn't check for it second time if it's not set
        User::doesntHave('photo') ->chunk(100, function ($usersWithoutAvatars) {
            foreach ($usersWithoutAvatars as $user) {
                $oldPhotoUrl = "https://i.arts.in.ua/i/$user->old_id/foto.jpg";
                $fileName = Str::slug($user->name) . '.jpg';
                DownloadAndSaveImage::dispatch('photos', $user, $oldPhotoUrl, $fileName);
            }
        });
    }
}
