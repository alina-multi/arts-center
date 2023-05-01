<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    protected $fillable = [
        'language',
        'text'
    ];
    use HasFactory;
}
