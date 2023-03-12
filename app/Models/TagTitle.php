<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagTitle extends Model
{
    use HasFactory;
    protected $fillable = ['language', 'title', 'tag_id'];
    public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
