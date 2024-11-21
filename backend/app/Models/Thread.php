<?php

namespace App\Models;

use App\Enums\ThreadType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Thread extends Model
{
    use HasFactory;

    protected $attributes = [
        'type' => ThreadType::Direct
    ];

    protected $casts = [
        'type' => ThreadType::class,
    ];

    protected $fillable = [
        'title'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
