<?php

namespace App\Nova\Actions;

use App\Models\Image;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ConvertUserImages extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (User $user) {
            Image::where('user_id', $user->id)->chunk(100, function (Collection $images) {
                $images->each(fn($image) => \App\Jobs\ConvertImage::dispatch($image));
            });
            $this->markAsFinished($user);
        });
    }
}
