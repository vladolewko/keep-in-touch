<?php

namespace App\Enums;

/** Enum NotificationTopicEnum  */
enum NotificationTopicEnum: string
{
    case LIKE    = 'like';
    case COMMENT = 'comment';
    case FOLLOW  = 'follow';
    case REPOST  = 'repost';
    case WARNING = 'warning';
    case BLOCK   = 'block';
    case OTHER   = 'other';
    case FOLLOW_REQUEST = 'follow_request';
    case FOLLOW_ACCEPTED = 'follow_accepted';

    /** @return string */
    public function label(): string
    {
        return match ($this) {
            self::LIKE    => 'Like',
            self::COMMENT => 'Comment',
            self::REPOST  => 'Repost',
            self::WARNING => 'Warning',
            self::BLOCK   => 'Block',
            self::OTHER   => 'Other',
            self::FOLLOW, self::FOLLOW_REQUEST, self::FOLLOW_ACCEPTED => true,
            default => false,
        };
    }

    /** @return array */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /** @return bool */
    public function isSystemGenerated(): bool
    {
        return match ($this) {
            self::LIKE, self::COMMENT, self::FOLLOW, self::REPOST => true,
            default => false,
        };
    }
}