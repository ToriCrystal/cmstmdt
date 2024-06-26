<?php

namespace App\Enums\Driver;

use App\Supports\Enum;

enum DriverTransactionStatus: int
{
    use Enum;

    //  Chưa chuyển khoản hệ thống
    case Pending = 1;

    // Đã chuyển khoản hệ thống
    case Success = 2;

    case Late = 3;

    public function badge(): string
    {
        return match ($this) {
            self::Success => 'bg-green',
            self::Pending => 'bg-yellow',
            self::Late => 'bg-red',
        };
    }

}
