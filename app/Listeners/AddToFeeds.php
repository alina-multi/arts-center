<?php

namespace App\Listeners;

use App\Comment;
use App\Events\CommentAdded;
use App\Events\WorkPublished;
use App\Feed;
use App\Follow;
use App\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddToFeeds
{
    protected $followableCriteria = [];

    /**
     * Handle the event.
     *
     * @param \App\Events\CommentAdded|\App\Events\WorkPublished $event
     * @return void
     */
    public function handle(CommentAdded|WorkPublished $event)
    {
        $model = $event->model;
        if ($model instanceof Comment) {
            // If subscribed to object that gets commented
            if ($model->commentable) {
                $this->addCriteria($model->commentable_type, $model->commentable_id);
                foreach ($this->extractOwnersFromModel($model->commentable) as $user) {
                    $this->addCriteria('user', $user->id);
                }
            }
            $this->attachToUserFeedsBasedOnCriteria($model);
        } elseif ($model instanceof Work) {
            $this->extractOwnersFromModel($model);
            $this->attachToUserFeedsBasedOnCriteria($model);
        }
    }

    public function addCriteria($followable_type, $followable_id)
    {
        $this->followableCriteria[] = [['followable_type', '=', $followable_type], ['followable_id', '=', $followable_id]];
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
        $query = Follow::groupBy('user_id');
        foreach ($this->followableCriteria as $where) {
            $query->orWhere($where);
        }
        $users = $query->get(['user_id'])->pluck(
            'user_id'
        )->toArray();
        foreach ($users as $user) {
            $feed = new Feed();
            $feed->feedable_type = $model->getMorphClass();
            $feed->feedable_id = $model->id;
            $feed->user_id = $user;
            $feed->save();
        }
    }
}
