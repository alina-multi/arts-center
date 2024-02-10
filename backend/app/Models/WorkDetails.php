<?php

namespace App\Models;

use App\Events\WorkUserPublished;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDetails extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updated(function ($workDetalis) {
            if ($workDetalis->work->published_at) {
                WorkUserPublished::dispatch($workDetalis->work);
            }
        });
    }

    protected $fillable = [
        'work_id', 'year', 'width', 'height', 'length', 'hosts'
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
