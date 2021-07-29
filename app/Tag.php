<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['type_id', 'old_id'];
    public $timestamps = false;
    const TYPE_CATEGORY = 1;
    const TYPE_TAG = 2;
    public function titles()
    {
        return $this->hasMany(TagTitle::class);
    }
}
