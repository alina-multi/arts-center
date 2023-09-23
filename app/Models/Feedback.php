<?php

namespace App\Models;

use App\Enums\FeedbackCategory;
use App\Enums\FeedbackType;
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

    protected $casts = [
        'approved_at'=> 'datetime',
        'type'=> FeedbackType::class,
        'category' => FeedbackCategory::class
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
