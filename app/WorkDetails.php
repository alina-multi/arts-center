<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkDetails extends Model
{
    protected $fillable = [
        'work_id', 'year', 'width', 'height', 'length', 'hosts'
    ];
}
