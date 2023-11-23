<?php

namespace App\Nova\Actions;

use App\Models\User;
use App\Notifications\ProfileApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ApproveRecord extends Action implements ShouldQueue
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
        $models->each(function ($model) {
            $model->approved_at = now();
            $model->save();
            if ($model instanceof User) {
                $model->notify(new ProfileApproved());
            }
            $this->markAsFinished($model);
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
