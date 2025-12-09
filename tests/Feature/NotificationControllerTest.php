<?php

namespace Tests\Feature;

use App\Enums\NotificationTopicEnum;
use App\Models\Notification;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;

class NotificationControllerTest extends AActionTest
{
    #[Test]
    public function userCanDisplayNotificationsPage(): void
    {
        Notification::factory()->count(3)->create([
            'sent_to_id' => $this->user->id,
            'topic' => NotificationTopicEnum::LIKE,
            'user_id' => User::factory(),
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('profile.notifications'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.notifications');
        $response->assertViewHas('notifications');
    }

    #[Test]
    public function userCanMarkSingleNotificationAsRead(): void
    {
        $notification = Notification::factory()->create([
            'sent_to_id' => $this->user->id,
            'topic' => NotificationTopicEnum::COMMENT,
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->user)
            ->patch(route('profile.notification.read', $notification->id));

        $response->assertRedirect();

        $this->assertTrue($notification->fresh()->is_read);
    }

    #[Test]
    public function userCanMarkAllNotificationsAsRead(): void
    {
        $notifications = Notification::factory()->count(3)->create([
            'sent_to_id' => $this->user->id,
            'topic' => NotificationTopicEnum::FOLLOW,
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->user)
            ->patch(route('profile.notification.read_all'));

        $response->assertRedirect();

        foreach ($notifications as $notification) {
            $this->assertTrue($notification->fresh()->is_read);
        }
    }

    #[Test]
    public function userSeesEmptyListIfNoNotifications(): void
    {
        Notification::where('sent_to_id', $this->user->id)->delete();

        $response = $this->actingAs($this->user)
            ->get(route('profile.notifications'));

        $response->assertStatus(200);
        $response->assertViewHas('notifications', function ($notifications) {
            return $notifications->isEmpty();
        });
    }
}