<?php

namespace App;

use App\Events\CommentAdded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['commentable_id', 'commentable_type', 'body', 'comment_id', 'user_id', 'depth'];

    protected $casts = [
        'body' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => CommentAdded::class,
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->hasOne(Comment::class);
    }

    public function canDelete($userId)
    {
        if ($this->user_id == $userId) {
            return true;
        }
        if ($this->commentable instanceof Work) {
            if ($this->commentable->owners->firstWhere('id', $userId)) {
                return true;
            }
        }
    }
}
