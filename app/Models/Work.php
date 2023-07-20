<?php

namespace App\Models;

use App\Enums\TagTypes;
use App\Events\PublishedWorkUpdated;
use App\Events\WorkDeleted;
use App\Events\WorkPublished;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use HasFactory, SoftDeletes, Publishable;

    protected $fillable = [
        'old_id', 'user_id', 'image_id', 'published_at', 'rating', 'price', 'hosts'
    ];

    protected $hidden = [
        'updated_at', 'old_id', 'hosts', 'show_en', 'show_ru', 'show_uk', 'old_user_id', 'titles'
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
        return $this->hasMany(WorkBlock::class)->orderBy('order');
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

    public function full()
    {
        return $this->hasOne(Image::class,'id','full_image_id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->where('type_id', TagTypes::TAG);
    }

    public function category()
    {
        return $this->morphToMany(Tag::class, 'taggable')->where('type_id', TagTypes::CATEGORY);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function owners()
    {
        return $this->morphToMany(User::class, 'ownable');
    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'votable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
