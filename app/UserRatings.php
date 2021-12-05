<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRatings extends Model
{
    protected $fillable = ['ratable_type', 'ratable_id', 'user_id', 'language'];

    protected $hidden = ['created_at', 'updated_at'];
    use HasFactory;

    public function ratable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
