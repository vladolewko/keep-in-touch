<?php

namespace App\Services;

use App\Models\UserNotification;
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
        return UserNotification::where('sent_to_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * @param int $notificationId
     * @return bool
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = UserNotification::find($notificationId);

        if ($notification && $notification->sent_to_id === auth()->id()) {
            return $notification->update(['is_read' => 1]);
        }

        return false;
    }

    /**
     * @param array $data
     * @param int   $senderId
     * @param int   $recipientId
     * @return UserNotification
     */
    public function sendMessage(array $data, int $senderId, int $recipientId): UserNotification
    {
        return UserNotification::create([
            'topic'        => $data['topic'],
            'message'      => $data['message'],
            'user_id'      => $senderId,
            'sent_to_id' => $recipientId,
        ]);
    }
}