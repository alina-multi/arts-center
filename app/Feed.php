<?php

namespace App;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Feed extends Model
{
    use HasFactory, BroadcastsEvents;

    public $work, $comment;
    protected $fillable = ['feedable_type', 'feedable_id', 'user_id'];
    protected $visible = ['feedable_type', 'feedable_id', 'user_id', 'created_at', 'feedable'];

    public function getWorkAttribute()
    {
        return $this->work;
    }

    public function getCommentAttribute()
    {
        return $this->comment;
    }

    public function feedable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function broadcastOn($event)
    {
        return [new PrivateChannel('user.' . $this->user_id)];
    }

    public function broadcastWith($event)
    {
        // Todo, make the format denormilized for frontend
        return match ($event) {
            'created' => [
                'model' => $this->load([
                                           'feedable' => function (MorphTo $morphTo) {
                                               $morphTo->morphWith([
                                                                       Work::class => ['image', 'owners', 'owners.photo'],
                                                                   ]);
                                           }
                                       ])
            ],
        };
    }
}
