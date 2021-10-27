<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRatings extends Model
{
    protected $fillable = ['ratable_type', 'ratable_id', 'user_id'];
    use HasFactory;
}
