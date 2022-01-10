<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function blog()
    {
        $this->belongsTo(Blog::class);
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }
}
