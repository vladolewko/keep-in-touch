<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;

class ProfileControllerTest extends AActionTest
{
    #[Test]
    public function userCanDisplayProfileIndexPage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('profile'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.index');
        $response->assertViewHas(['user', 'publications', 'reposts']);
    }

    #[Test]
    public function userCanDisplayEditProfilePage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user');
    }

    #[Test]
    public function userCanUpdateProfileInformation(): void
    {
        $newData = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'nickname' => 'updated_nick_unique',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($this->user)
            ->patch(route('profile.update'), $newData);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'nickname' => 'updated_nick_unique',
        ]);
    }

    #[Test]
    public function userCanDisplayFollowersPage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('profile.followers'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.followers');
    }

    #[Test]
    public function userCanDisplaySubscriptionsPage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('profile.subscriptions'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.subscriptions');
        $response->assertViewHas('subscriptions');
    }

    #[Test]
    public function userCanManageSubscriptionRequest(): void
    {
        $subscriber = User::factory()->create();

        $data = [
            'subscriber_id' => $subscriber->id,
            'action' => 'accept',
        ];

        $response = $this->actingAs($this->user)
            ->patch(route('user.manageSubscriptions'), $data);

        $response->assertRedirect();
    }

    #[Test]
    public function userCanDisplayNotificationsPage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('profile.notifications'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.notifications');
        $response->assertViewHas('notifications');
    }

    #[Test]
    public function userCanMarkNotificationAsRead(): void
    {
        $notificationId = 1;

        $response = $this->actingAs($this->user)
            ->patch(route('profile.notification.read', $notificationId));

        $response->assertRedirect();
    }

    #[Test]
    public function userCanMarkAllNotificationsAsRead(): void
    {
        $response = $this->actingAs($this->user)
            ->patch(route('profile.notification.read_all'));

        $response->assertRedirect();
    }

    #[Test]
    public function userCanChangeProfileAccess(): void
    {
        $data = [
            'access' => 'private',
        ];

        $response = $this->actingAs($this->user)
            ->patch(route('profile.changeAccess'), $data);

        $response->assertRedirect();
    }

    #[Test]
    public function userCanDestroyAccountWithCorrectPassword(): void
    {
        $this->user->update([
            'password' => Hash::make('password')
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('profile.destroy'), [
                'password' => 'password',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');

        $this->assertSoftDeleted('users', [
            'id' => $this->user->id,
        ]);
    }

    #[Test]
    public function userCannotDestroyAccountWithWrongPassword(): void
    {
        $response = $this->actingAs($this->user)
            ->delete(route('profile.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrorsIn('userDeletion', 'password');

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
        ]);
    }
}