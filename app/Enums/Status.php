<?php

namespace App\Enums;

enum Status: string
{
    case Pending = 'pending';
    case Public = 'public';
    case Deleted = 'deleted';
    case Reject = 'reject';
}
