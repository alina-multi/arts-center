<?php

namespace App\Nova\Actions;

use App\Models\Message;
use App\Models\Participant;
use App\Notifications\NewMessage;
use App\Notifications\ProfileApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ApproveMessage extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection<Message> $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Message $message) {
            $message?->thread?->participants?->whereNull('approved_at')->each(function (Participant $participant) use ($message) {
                $participant->approved_at = now();
                $participant->save();
                $participant->user->notify(new NewMessage($message, $participant->user_id));
            });
            $message->user->update(['approved_at' => now()]);
            $message->user->notify(new ProfileApproved());
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
