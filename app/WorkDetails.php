<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id', 'year', 'width', 'height', 'length', 'hosts'
    ];
}
