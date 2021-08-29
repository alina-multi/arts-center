<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkTitle extends Model
{
    use HasFactory;

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
