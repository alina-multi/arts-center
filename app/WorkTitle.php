<?php

namespace App;

use App\Events\PublishedWorkUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkTitle extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function ($workTitle) {
            if ($workTitle->work->published_at) {
                PublishedWorkUpdated::dispatch($workTitle->work);
            }
        });
    }

    protected $fillable = [
        'created_at', 'work_id', 'language', 'title'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function work ()
    {
        return $this->belongsTo(Work::class,'work_id');
    }
}
