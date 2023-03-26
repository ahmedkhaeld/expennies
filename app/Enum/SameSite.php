<?php

namespace App\Enum;

enum SameSite: string
{
    case Lax = 'lax';
    case Strict = 'strict';
    case None = 'none';
}
