<?php

namespace App\Enums;

enum FeedbackType: string
{
    case idea = 'idea';
    case complaint = 'complaint';
    case feedback = 'feedback';
}
