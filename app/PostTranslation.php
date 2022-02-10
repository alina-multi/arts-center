<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTranslation extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'post_id', 'body', 'deleted_at', 'created_at', 'updated_at'
    ];
    protected $fillable = [
      'title', 'language', 'body'
    ];

    protected $casts = [
        'body' => 'array',
    ];
}
