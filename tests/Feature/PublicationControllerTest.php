<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationControllerTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . env('API_ACCESS_TOKEN', 'test-token'),
        ];
    }

    public function test_it_returns_all_publications()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $publications = Publication::factory()->count(2)->create();

        $response = $this->getJson(route('publications.index'), $this->authHeaders());
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $publications[0]->id])
            ->assertJsonFragment(['id' => $publications[1]->id]);
    }

    public function test_it_returns_publications_by_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userAuthor = User::factory()->create();
        $publication = Publication::factory()->create([
            'user_id' => $userAuthor->id,
            'title' => 'Test Publication',
        ]);

        $response = $this->getJson(route('user.publications', ['id' => $userAuthor->id]), $this->authHeaders());
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $publication->id,
                'title' => $publication->title,
                'user' => [
                    'id' => $userAuthor->id,
                    'nickname' => $userAuthor->nickname,
                ],
            ]);
    }

    public function test_it_creates_publication_for_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'title' => 'New Publication',
            'description' => 'Some description',
        ];

        $response = $this->postJson(route('publications.store', ['id' => $user->id]), $payload, $this->authHeaders());

        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'New Publication',
                'description' => 'Some description',
                'user' => [
                    'id' => $user->id,
                    'nickname' => $user->nickname,
                ],
            ]);
        $this->assertDatabaseHas('publications', [
            'title' => 'New Publication',
            'user_id' => $user->id,
        ]);
    }

    public function test_it_validates_publication_creation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('publications.store', ['id' => $user->id]), [], $this->authHeaders());
        $response->assertStatus(422);
    }

    public function test_it_shows_publication_by_id()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $publication = Publication::factory()->create();

        $response = $this->getJson(route('publications.show', ['id' => $publication->id]), $this->authHeaders());
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $publication->id,
                'title' => $publication->title,
            ]);
    }

    public function test_it_returns_404_if_publication_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('publications.show', ['id' => 9999]), $this->authHeaders());
        $response->assertStatus(404);
    }

    public function test_it_updates_publication()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $publication = Publication::factory()->create();

        $payload = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ];

        $response = $this->putJson(route('publications.update', ['publicationId' => $publication->id]), $payload, $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Updated Title',
                'description' => 'Updated Description',
            ]);
        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_it_returns_404_on_update_if_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ];

        $response = $this->putJson(route('publications.update', ['publicationId' => 9999]), $payload, $this->authHeaders());
        $response->assertStatus(404);
    }

    public function test_it_validates_publication_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $publication = Publication::factory()->create();

        $response = $this->putJson(route('publications.update', ['publicationId' => $publication->id]), [], $this->authHeaders());
        $response->assertStatus(422);
    }

    public function test_it_deletes_publication()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $publication = Publication::factory()->create();

        $response = $this->deleteJson(route('publications.destroy', ['id' => $publication->id]), [], $this->authHeaders());
        $response->assertStatus(200)
            ->assertJson(['message' => 'Publication deleted successfully']);
        $this->assertDatabaseMissing('publications', ['id' => $publication->id]);
    }

    public function test_it_returns_404_on_delete_if_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->deleteJson(route('publications.destroy', ['id' => 9999]), [], $this->authHeaders());
        $response->assertStatus(404);
    }
}
