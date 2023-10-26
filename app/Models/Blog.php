<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

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
        return $this->morphToMany(User::class, 'ownable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
