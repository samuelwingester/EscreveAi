<?php

namespace App\Models\Enums;

enum Gender: string
{
    case MAN = 'man';
    case WOMAN = 'woman';
    case NULL = '';
}
