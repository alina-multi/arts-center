<?php

namespace App\Models;

use App\Enums\TransactionTypes;
use App\Events\TransactionCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_user_id',
        'from_user_id',
        'from_email',
        'event',
        'amount_gross',
        'amount_net',
        'message',
        'type',
        'currency',
        'stripe_net',
        'stripe_fee',
        'our_fee',
        'payment_intent'
    ];

    protected $casts = [
        'event' => 'array',
        'type' => TransactionTypes::class
    ];

    public function to()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
