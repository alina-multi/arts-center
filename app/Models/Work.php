<?php

namespace App\Models;

use App\Enums\TagTypes;
use App\Enums\WorkStatuses;
use App\Events\WorkUserPublished;
use App\Events\WorkDeleted;
use App\Events\WorkPublished;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Work extends Model
{
    use HasFactory, SoftDeletes, Publishable, Searchable;

    protected $fillable = [
        'old_id', 'user_id', 'image_id', 'published_at', 'rating', 'price', 'hosts', 'full_image_id', 'status'
    ];

    protected $hidden = [
        'updated_at', 'old_id', 'hosts', 'show_en', 'show_ru', 'show_uk', 'old_user_id', 'titles'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => WorkStatuses::class
    ];

    protected $dispatchesEvents = [
        'deleted' => WorkDeleted::class,
    ];

    /*

     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (int)$this->id,
            'published_at' => $this->published_at?->toDateTimeString(),
            'rating' => (int)$this->rating,
            'comments' => (int)$this->comments,
            'hosts' => (int)$this->hosts,
            'price' => (int)$this->price,
            'titles' => $this->titles?->toArray(),
            'preview' => $this->preview?->toArray(),
            'owners' => $this->owners->toArray()
        ];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with('titles', 'preview', 'preview.variants', 'owners', 'owners.photo', 'owners.photo.variants')
            ->whereNotNull('published_at');
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

    public function preview()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function full()
    {
        return $this->belongsTo(Image::class, 'full_image_id');
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
        return $this->morphMany(Vote::class, 'votable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
