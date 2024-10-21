<?php

namespace App\Models;

use App\Enums\ThreadType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => ThreadType::class,
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
