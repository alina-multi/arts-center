<?php

namespace App\Models;

use App\Events\PublishedWorkUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkBlock extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function ($workBlock) {
            if ($workBlock->work->published_at) {
                PublishedWorkUpdated::dispatch($workBlock->work);
            }
        });
    }

    protected $fillable = [
        'created_at', 'work_id', 'language', 'type', 'order', 'data'
    ];
    protected $casts = [
        'data' => 'array',
    ];

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
