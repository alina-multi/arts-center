<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = ['vote', 'votable_id', 'votable_type', 'ip', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
