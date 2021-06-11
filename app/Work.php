<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_id', 'user_id', 'image_id', 'published_at'
    ];

    protected $hidden = [
        'updated_at', 'old_id', 'hosts', 'image_id'
    ];

    public function blocks()
    {
        return $this->hasMany(WorkBlock::class);
    }

    public function details()
    {
        return $this->hasOne(WorkDetails::class);
    }

    public function titles()
    {
        return $this->hasMany(WorkTitle::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class,'id','image_id');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function owners()
    {
        return $this->morphToMany('App\User', 'ownable');
    }
}
