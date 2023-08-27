<?php

namespace App\Models;

use App\Events\WorkUserPublished;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkTitle extends Model
{
    use HasFactory;

    protected static function booted()
    {
//        static::updated(function ($workTitle) {
//            if ($workTitle->work->published_at) {
//                PublishedWorkUpdated::dispatch($workTitle->work);
//            }
//        });
    }

    protected $fillable = [
        'created_at', 'work_id', 'language', 'title', 'description', 'alt'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $visible = [
        'title', 'language', 'description', 'alt', 'colors'
    ];

    public function work ()
    {
        return $this->belongsTo(Work::class);
    }
}
