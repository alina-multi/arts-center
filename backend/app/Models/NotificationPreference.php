<?php

namespace App\Models;

use App\Enums\NotificationChannels;
use App\Enums\NotificationTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'channel', 'user_id'];
    protected $visible = ['type', 'channel'];
    public $timestamps = false;
    protected $casts = [
        'type' => NotificationTypes::class,
        'channel' => NotificationChannels::class
    ];
}
