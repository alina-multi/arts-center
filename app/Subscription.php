<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'subscribable_type', 'subscribable_id'];
    protected $visible = ['id', 'user_id', 'subscribable_type', 'subscribable_id'];
}
