<?php

namespace App\Models;

use App\Events\VoteCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = ['vote', 'votable_id', 'votable_type', 'ip', 'user_id'];
    protected $visible = ['id', 'user_id', 'created_at', 'vote', 'user'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function votable()
    {
        return $this->morphTo();
    }

    protected $dispatchesEvents = [
        'created'=> VoteCreated::class
    ];
}
