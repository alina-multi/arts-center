<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'blacklist_user_id'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function blacklist()
    {
        return $this->hasOne(User::class,'id','blacklist_user_id');
    }
}
