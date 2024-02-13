<?php

namespace App\Models;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, Publishable;

    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

    protected $fillable = [
        'user_id', 'published_at', 'title', 'body', 'language'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'body' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }
}
