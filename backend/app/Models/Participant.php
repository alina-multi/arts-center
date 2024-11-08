<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    protected $casts = [
        'approved_at' => 'datetime',
        'last_read' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'user_id',
        'approved_at'
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
