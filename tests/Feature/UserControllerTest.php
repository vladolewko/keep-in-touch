<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;

class UserControllerTest extends AActionTest
{
    #[Test]
    public function userCanDisplayUsersIndexPage(): void
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('users'));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }

    #[Test]
    public function userCanDisplayUsersSortedPage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('users.sort', ['sort' => 'name', 'direction' => 'asc']));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }

    #[Test]
    public function userCanDisplaySpecificUserProfile(): void
    {
        $otherUser = User::factory()->create();

        Publication::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)
            ->get(route('users.profile', $otherUser->id));

        $response->assertStatus(200);
        $response->assertViewIs('users.user');

        $response->assertViewHas([
            'user',
            'publications',
            'reposts',
            'haveAccess',
            'subscriptionStatus'
        ]);

        $response->assertViewHas('user', function (User $viewUser) use ($otherUser) {
            return $viewUser->id === $otherUser->id;
        });
    }

    #[Test]
    public function userReturns404WhenViewingNonExistentUser(): void
    {
        $nonExistentId = 999999;

        $response = $this->actingAs($this->user)
            ->get(route('users.profile', $nonExistentId));

        $response->assertStatus(404);
    }

    #[Test]
    public function userCanToggleSubscription(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->post(route('user.changeSubscription'), [
                'user_id' => $targetUser->id
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    #[Test]
    public function userValidatesInputWhenChangingSubscription(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('user.changeSubscription'), []);

        $response->assertSessionHasErrors('user_id');
    }

    #[Test]
    public function userCannotSubscribeToNonExistentUser(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('user.changeSubscription'), [
                'user_id' => 999999
            ]);

        $response->assertSessionHasErrors('user_id');
    }
}