<?php

namespace App\Enums;

enum Status: string
{
    case Pending = 'In Progess';
    case Public = 'public';
    case Deleted = 'deleted';
    case Reject = 'reject';
}