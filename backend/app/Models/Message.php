<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $touches = ['thread'];

    protected $hidden = [
        'deleted_at', 'user_id'
    ];

    protected $fillable = [
        'message', 'user_id'
    ];

    function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
