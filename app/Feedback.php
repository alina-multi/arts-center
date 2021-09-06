<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'title',
        'body',
        'type',
        'category',
        'user_id',
        'feedbackable_type',
        'feedbackable_id'
    ];
    const TYPE_CATEGORY = [
        'idea' => [

        ],
        'complaint' => [
            'porn',
            'insult',
            'fraud',
            'spam',
            'politics',
            'copyright',
            'violence',
            'other'
        ],
        'feedback' => [

        ]
    ];

    protected $casts = [
        'body' => 'array',
    ];
}
