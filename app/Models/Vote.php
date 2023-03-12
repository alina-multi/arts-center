<?php

namespace App\Models;

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
}
