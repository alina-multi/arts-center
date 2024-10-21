<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Participant extends Model
{
    use HasFactory;

    protected $casts = [
        'approved_at' => 'datetime',
        'last_read' => 'datetime',
    ];

    protected $visible = [
        'id', 'user_id', 'last_read', 'approved_at',
    ];

    protected $fillable = [
        'user_id',
        'approved_at'
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function user(): MorphTo
    {
        return $this->morphTo(User::class);
    }
}
