<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }

    public function owners()
    {
        return $this->morphToMany('App\User', 'ownable');
    }
}
