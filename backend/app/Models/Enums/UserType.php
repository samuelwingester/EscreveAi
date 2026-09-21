<?php

namespace App\Models\Enums;

enum UserType: string
{
    # case STUDENT = 'student';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';
}
