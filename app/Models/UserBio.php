<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    use HasFactory;
    protected $fillable = [
        'language',
        'text'
    ];

    protected $visible = ['language', 'text'];
}
