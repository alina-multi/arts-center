<?php

namespace App\Enums;

enum UserIntents: string
{
    case Explore = 'explore';
    case Buy = 'buy';
    case Sell = 'sell';
    case Network = 'network';
}
