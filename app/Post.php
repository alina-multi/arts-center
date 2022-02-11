<?php

namespace App;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, Publishable;

    protected $hidden = ['created_at','deleted_at','updated_at'];

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
