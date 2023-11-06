<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Events\CommentCreated;
use App\Events\WorkPublished;
use App\Models\Feed;
use App\Models\Follow;
use App\Models\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddToFeeds
{
    protected $followableCriteria = [];

    /**
     * Handle the event.
     *
     * @param CommentNotifications|WorkPublished $event
     * @return void
     */
    public function handle(CommentCreated|WorkPublished $event)
    {
        $model = $event->model;
        if ($model instanceof Comment) {
            // If subscribed to object that gets commented
            if ($model->commentable) {
                $this->addCriteria($model->commentable_type, $model->commentable_id);
                // Send to people subscribed to this commentable owners
                $owners = $this->extractOwnersFromModel($model->commentable);
                foreach ($owners as $user) {
                    $this->addCriteria('user', $user->id);
                }
                // Also attach to commentable owner feed
                $this->attachToUsers($model, $owners);
            }
            $this->attachToUserFeedsBasedOnCriteria($model);
        } elseif ($model instanceof Work) {
            // Send to people subscribed to this work owners
            $owners = $this->extractOwnersFromModel($model);
            foreach ($owners as $user) {
                $this->addCriteria('user', $user->id);
            }
            $this->attachToUserFeedsBasedOnCriteria($model);
        }
    }

    public function addCriteria($followable_type, $followable_id)
    {
        $this->followableCriteria[] = [
            ['followable_type', '=', $followable_type],
            ['followable_id', '=', $followable_id]
        ];
    }

    public function extractOwnersFromModel($model)
    {
        if (isset($model->user) && $model->user) {
            return [$model->user];
        } elseif (isset($model->owners) && $model->owners) {
            return $model->owners;
        }
        return [];
    }

    public function attachToUserFeedsBasedOnCriteria($model)
    {
        if (sizeof($this->followableCriteria)) {
            $query = Follow::groupBy('user_id');
            foreach ($this->followableCriteria as $where) {
                $query->orWhere($where);
            }
            $users = $query->get(['user_id'])->pluck(
                'user_id'
            )->toArray();
            $this->attachToUsers($model, $users);
        }
    }

    public function attachToUsers ($model, $owners)
    {
        foreach ($owners as $owner) {
            $userId = is_object($owner) ? $owner->id : $owner;
            $feed = new Feed();
            $feed->feedable_type = $model->getMorphClass();
            $feed->feedable_id = $model->id;
            $feed->user_id = $userId;
            $feed->save();
        }
    }
}
