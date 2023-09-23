<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteFolder extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title'];
    protected $visible = ['id', 'title', 'works'];

    function works(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Work::class, 'favorites');
    }
}
