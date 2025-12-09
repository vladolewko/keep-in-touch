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
    // app/Notifications/DatabaseNotification.php

    public function toDatabase(object $notifiable): array
    {
        if ($this->topic->isSystemGenerated()) {
            $message = $this->generateSystemMessage();
        } else {
            $message = $this->message;
        }

        return [
            'topic'       => $this->topic->value,
            'message'     => $message,
            'user_id'     => $this->sender->id ?? null,
            // ВАЖЛИВО: Зберігаємо ID об'єкта, щоб потім можна було знайти і видалити цей лайк
            'object_id'   => $this->contextData['post_id'] ?? null,
            'action_url'  => $this->contextData['url'] ?? null, // Корисно мати посилання
        ];
    }

    protected function generateSystemMessage(): string
    {
        $senderName = $this->sender?->nickname ?? $this->sender?->name ?? 'Користувач';
        // Беремо ТІЛЬКИ назву, якщо вона є, інакше просто "публікація"
        $postTitle  = $this->contextData['post_title'] ?? null;

        return match ($this->topic) {
            // Результат: "Ivan вподобав вашу публікацію." або "Ivan вподобав вашу публікацію: Мій відпочинок."
            NotificationTopicEnum::LIKE => $postTitle
                ? "{$senderName} вподобав вашу публікацію: \"{$postTitle}\"."
                : "{$senderName} вподобав вашу публікацію.",

            NotificationTopicEnum::COMMENT => $postTitle
                ? "{$senderName} прокоментував вашу публікацію: \"{$postTitle}\"."
                : "{$senderName} прокоментував вашу публікацію.",

            NotificationTopicEnum::FOLLOW => "{$senderName} тепер стежить за вами.",
            default => $this->message,
        };
    }
}
