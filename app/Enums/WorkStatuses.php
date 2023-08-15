<?php

namespace App\Enums;

enum WorkStatuses: int
{
    case ERROR = 0;
    case DELETED = 4;
    case DRAFT = 5;

    case USER_PUBLISHED = 10;
    case PROCESSING = 20;
    case READY = 30;
    case PUBLISHED = 40;
    case PUBLISHED_PREMIUM = 50;
    case PUBLISHED_FUTURED = 60;
}
