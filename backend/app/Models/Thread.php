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

    protected $fillable = [
        'title'
    ];

    protected $visible = [
      'id', 'title', 'created_at', 'updated_at', 'participants', 'messages'
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class)->whereNotNull('approved_at');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
