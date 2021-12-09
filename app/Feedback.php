<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Feedback extends Model
{
    use HasFactory, Actionable;

    protected $fillable = [
        'language',
        'title',
        'body',
        'type',
        'category',
        'user_id',
        'feedbackable_type',
        'feedbackable_id',
        'approved_at'
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
        'approved_at'=> 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'votable');
    }
}
