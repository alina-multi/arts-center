<?php

namespace App\Nova\Actions;

use App\Notifications\ProfileVerified;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class VerifyUser extends Action
{
    use InteractsWithQueue, Queueable;


    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->verified_at = $model->freshTimestamp();
            $model->save();
            $model->notify(new ProfileVerified());
            $this->markAsFinished($model);
        }
    }
}
