<?php

namespace App\Nova\Actions;

use App\Enums\WorkStatuses;
use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ReadyWork extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Move to ready';
    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->map(function (Work $work) {
            $work->update(['status' => WorkStatuses::READY->value]);
            $work->unsearchable();
        });
    }
}
