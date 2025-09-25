<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case InProgress = 'in_progress';
    case Public = 'public';
    case Deleted = 'deleted';
    case Reject = 'reject';
}
