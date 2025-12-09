<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;
use Tests\TestCase;

/** Class PublicationControllerTest*/
class PublicationControllerTest extends AActionTest
{
    /** @return void */
    #[Test]
    public function it_can_display_the_index_page(): void
    {
        Publication::factory()->count(3)->create();
        $response = $this->actingAs($this->user)
            ->get(route('publications'));

        $response->assertStatus(200);
        $response->assertViewIs('publications.index');
        $response->assertViewHas('publications');
    }

    /** @return void */
    #[Test]
    public function it_can_create_a_publication_with_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('post.jpg');

        $data = [
            'title' => 'New Publication',
            'description' => 'Description content',
            'image' => $image,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('publication.create'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('publications', [
            'title' => 'New Publication',
            'user_id' => $this->user->id,
        ]);
    }

    /** @return void */
    #[Test]
    public function it_displays_edit_page_for_owner(): void
    {
        $publication = Publication::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)
            ->get(route('publication.edit', $publication->id));

        $response->assertStatus(200);
        $response->assertViewIs('publications.edit');
    }

    /** @return void */
    #[Test]
    public function it_can_update_a_publication(): void
    {
        $publication = Publication::factory()->create(['user_id' => $this->user->id]);
        $data = [
            'publication_id' => $publication->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ];

        $response = $this->actingAs($this->user)
            ->patch(route('publication.update'), $data);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('publications', [
            'id' => $publication->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @return void */
    #[Test]
    public function it_cannot_update_others_publication(): void
    {
        $otherUser = User::factory()->create();
        $publication = Publication::factory()->create(['user_id' => $otherUser->id]);

        $data = [
            'publication_id' => $publication->id,
            'title' => 'Hacked Title',
        ];

        $response = $this->actingAs($this->user)
            ->patch(route('publication.update'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Unauthorized action');

        $this->assertDatabaseMissing('publications', [
            'id' => $publication->id,
            'title' => 'Hacked Title',
        ]);
    }

    /** @return void */
    #[Test]
    public function it_can_toggle_like(): void
    {
        $publication = Publication::factory()->create();

        $response = $this->actingAs($this->user)
            ->postJson(route('publication.like'), [
                'publication_id' => $publication->id
            ]);

        $response->assertStatus(200);
    }

    /** @return void */
    #[Test]
    public function it_can_toggle_repost(): void
    {
        $publication = Publication::factory()->create();

        $response = $this->actingAs($this->user)
            ->postJson(route('publication.repost'), [
                'publication_id' => $publication->id
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /** @return void */
    #[Test]
    public function it_can_toggle_status_hide(): void
    {
        $publication = Publication::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->patch(route('publication.hide'), [
                'publication_id' => $publication->id
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @return void */
    #[Test]
    public function it_can_destroy_publication(): void
    {
        $publication = Publication::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('publication.destroy', $publication->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('publications', ['id' => $publication->id]);
    }
}