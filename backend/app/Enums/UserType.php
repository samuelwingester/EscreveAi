<?php

namespace App\Enums;

enum UserType: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
}