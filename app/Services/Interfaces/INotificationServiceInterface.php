<?php

namespace App\Services\Interfaces;

use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Collection;

/** Interface INotificationServiceInterface */
interface INotificationServiceInterface
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function get(int $userId): Collection;

    /**
     * @param int $notificationId
     * @return bool
     */
    public function markAsRead(int $notificationId): bool;

    /**
     * @param array $data
     * @param int   $senderId
     * @param int   $recipientId
     * @return UserNotification
     */
    public function sendMessage(array $data, int $senderId, int $recipientId): UserNotification;
}