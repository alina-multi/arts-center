<?php

namespace App;

use App\Events\PublishedWorkUpdated;
use App\Events\WorkDeleted;
use App\Events\WorkPublished;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'old_id', 'user_id', 'image_id', 'published_at', 'rating', 'price', 'hosts'
    ];

    protected $hidden = [
        'updated_at', 'old_id', 'hosts'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'deleted' => WorkDeleted::class,
    ];

    protected static function booted()
    {
        static::updated(function ($work) {
            if ($work->published_at) {
                if (!$work->getOriginal('published_at')) {
                    WorkPublished::dispatch($work);
                } else {
                    PublishedWorkUpdated::dispatch($work);
                }
            }
        });
    }


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
        return $this->morphToMany('App\Tag', 'taggable')->where('type_id', Tag::TYPE_TAG);
    }

    public function category()
    {
        return $this->morphToMany('App\Tag', 'taggable')->where('type_id', Tag::TYPE_CATEGORY);
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function owners()
    {
        return $this->morphToMany('App\User', 'ownable');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'votable');
    }
}
