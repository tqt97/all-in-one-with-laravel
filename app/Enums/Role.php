<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case LIBRARIAN = 'librarian';
    case TEACHER = 'teacher';
}
