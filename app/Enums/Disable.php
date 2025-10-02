<?php

namespace App\Enums;

enum Disable: string
{
    case Processing = 'đang tiến hành';
    case Finished   = 'hoàn thành';
    case Deleted    = 'đã xóa';
    case Reject     = 'tạm hoãn';

    public function toBool(): bool
    {
        return match ($this) {
            self::Processing => false,
            self::Finished   => true,
            self::Deleted    => true,
            self::Reject     => true,
        };
    }
}
