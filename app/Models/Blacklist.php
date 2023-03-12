<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'blacklist_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blacklist()
    {
        return $this->belongsTo(User::class,'blacklist_user_id');
    }
}
