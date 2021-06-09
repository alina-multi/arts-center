<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagTitle extends Model
{
    protected $fillable = ['language', 'title', 'tag_id'];
    public $timestamps = false;
}
