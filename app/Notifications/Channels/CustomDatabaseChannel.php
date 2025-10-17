<?php
// app/Notifications/DatabaseNotification.php

namespace App\Notifications\Channels;

use App\Models\Notification;
use Illuminate\Notifications\Notification as DefaultNotification;

/** Class DatabaseNotification */
class CustomDatabaseChannel
{
    /**
     * @param  mixed  $notifiable (Це User, який отримує сповіщення)
     * @param  DefaultNotification  $notification (Це ваш DatabaseNotification)
     * @return Notification
     */
    public function send(mixed $notifiable, DefaultNotification $notification): Notification
    {
        $data = $notification->toDatabase($notifiable);

        return Notification::create([
            'sent_to_id' => $notifiable->getKey(),
            'user_id'    => $data['user_id'] ?? null,
            'topic'      => $data['topic'],
            'message'    => $data['message'],
            'is_read'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}