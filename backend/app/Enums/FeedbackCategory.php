<?php

namespace App\Enums;

enum FeedbackCategory: string
{
    case porn = 'porn';
    case insult = 'insult';
    case fraud = 'fraud';
    case spam = 'spam';
    case politics = 'politics';
    case copyright = 'copyright';
    case violence = 'violence';
    case other = 'other';
}
