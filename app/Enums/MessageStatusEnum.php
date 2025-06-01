<?php

namespace App\Enums;

enum MessageStatusEnum: string
{
    case Pending = 'pending';
    case Processed = 'processed';
    case Closed = 'closed';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
