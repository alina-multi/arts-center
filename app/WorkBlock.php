<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at', 'work_id', 'language', 'type', 'order', 'data'
    ];
    protected $casts = [
        'data' => 'array',
    ];

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function work()
    {
        return $this->belongsTo('App\Work','id','work_id');
    }
}
