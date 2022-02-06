<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blog_id', 'published_at'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }
}
