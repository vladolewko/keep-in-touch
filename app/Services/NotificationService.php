<?php

namespace App\Services;

use App\Models\Notification;
use App\Services\Interfaces\INotificationServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/** Class NotificationService */
class NotificationService implements INotificationServiceInterface
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function get(int $userId): Collection
    {
        return Notification::where('sent_to_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * @param int $notificationId
     * @return bool
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = Notification::where('sent_to_id', auth()->id())
            ->where('id', $notificationId)
            ->first();

        if ($notification && !$notification->is_read) {
            $notification->is_read = true;
            return $notification->save();
        }

        return false;
    }

    /**
     * @param array $data
     * @param int   $senderId
     * @param int   $recipientId
     * @return Notification
     */
    public function sendMessage(array $data, int $senderId, int $recipientId): Notification
    {
        return Notification::create([
            'topic'        => $data['topic'],
            'message'      => $data['message'],
            'user_id'      => $senderId,
            'sent_to_id' => $recipientId,
        ]);
    }

    /**
     * @param int $recipientId
     * @return int
     */
    public function markAllAsRead(int $recipientId): int
    {
        return Notification::where('sent_to_id', $recipientId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * @param int $recipientId ID користувача, який отримує сповіщення (ваш sent_to_id)
     * @return int
     */
    public function getUnreadCount(int $recipientId): int
    {
        return Notification::where('sent_to_id', $recipientId)
            ->where('is_read', false)
            ->count();
    }
}