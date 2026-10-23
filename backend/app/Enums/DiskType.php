<?php

namespace App\Enums;

enum DiskType: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'local';
    case TESTING = 'testing';
}
