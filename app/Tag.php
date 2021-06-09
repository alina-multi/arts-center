<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['type_id', 'old_id'];
    public $timestamps = false;
    public function titles()
    {
        return $this->hasMany(TagTitle::class);
    }
}
