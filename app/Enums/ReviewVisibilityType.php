<?php

namespace App\Enums;

enum ReviewVisibilityType: string
{
    case PUBLIC = 'public';
    case ANONYMOUS = 'anonymous';
}
