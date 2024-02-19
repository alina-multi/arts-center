<?php

namespace App\Enums;

enum UserRoles: int
{
    case User = 0;
    case SuperAdmin = 10;
}
