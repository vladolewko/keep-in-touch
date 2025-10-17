<?php
// app/Notifications/DatabaseNotification.php

namespace App\Notifications;

use App\Notifications\Channels\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Enums\NotificationTopicEnum;
use App\Models\User;

/** Class DatabaseNotification */
class DatabaseNotification extends Notification
{
    use Queueable;

    /** @var NotificationTopicEnum */
    protected NotificationTopicEnum $topic;
    /** @var string */
    protected string $message;
    /** @var null|User */
    protected ?User $sender;
    /** @var array */
    protected array $contextData;

    /**
     * @param string|null $message - використовується для Admin/Warning/Other
     * @param User|null $sender - користувач, який ініціював дію (або Admin)
     * @param array $contextData - дані для генерації повідомлення (Post/Comment)
     */
    public function __construct(
        NotificationTopicEnum $topic,
        ?string $message = null,
        ?User $sender = null,
        array $contextData = []
    ) {
        $this->topic = $topic;
        $this->message = $message ?? '';
        $this->sender = $sender;
        $this->contextData = $contextData;
    }

    /**
     * @param  object  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [CustomDatabaseChannel::class];
    }

    /**
     * @param object $notifiable
     * @return array
     */
    public function toDatabase(object $notifiable): array
    {
        if ($this->topic->isSystemGenerated()) {
            $message = $this->generateSystemMessage();
        } else {
            $message = $this->message;
        }

        return [
            'topic'      => $this->topic->value,
            'message'    => $message,
            'user_id'    => $this->sender->id ?? null,
            // 'sent_to_id' - це ID отримувача, його надає Laravel через $notifiable->id
        ];
    }

    /** @return string */
    protected function generateSystemMessage(): string
    {
        $senderName = $this->sender?->nickname ?? $this->sender?->name ?? 'Користувач';
        $postTitle  = $this->contextData['post_title'] ?? 'невідомий пост';
        $itemType   = $this->contextData['item_type'] ?? 'об\'єкт';

        return match ($this->topic) {
            NotificationTopicEnum::LIKE => "{$senderName} сподобалася ваша {$postTitle}.",
            NotificationTopicEnum::COMMENT => "{$senderName} прокоментував вашу {$postTitle}.",
            NotificationTopicEnum::FOLLOW => "{$senderName} тепер стежить за вами.",
            NotificationTopicEnum::FOLLOW_ACCEPTED => "{$senderName} прийняв ваш запит на підписку.",
            default => $this->message,
        };
    }
}
