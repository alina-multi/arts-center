<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTranslation extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'blog_id', 'deleted_at', 'created_at', 'updated_at'
    ];

    protected $fillable = [
      'language', 'title', 'about'
    ];

    protected $casts = [
        'about' => 'array',
    ];
}
