<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\PublicationComment;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;

class PublicationCommentControllerTest extends AActionTest
{
    #[Test]
    public function it_can_store_a_comment()
    {
        $publication = Publication::factory()->create();
        $data = [
            'publication_id' => $publication->id,
            'comment' => 'This is a test comment',
        ];

        // ВИПРАВЛЕНО: put() та 'comment.create'
        $response = $this->actingAs($this->user)
            ->put(route('comment.create'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('publication_comments', [
            'publication_id' => $publication->id,
            'user_id' => $this->user->id,
            'comment' => 'This is a test comment',
        ]);
    }

    #[Test]
    public function it_fails_validation_when_storing_comment()
    {
        // ВИПРАВЛЕНО: put() та 'comment.create'
        $response = $this->actingAs($this->user)
            ->put(route('comment.create'), []);

        $response->assertSessionHasErrors(['publication_id', 'comment']);
    }

    #[Test]
    public function it_cannot_comment_on_non_existent_publication()
    {
        $data = [
            'publication_id' => 99999,
            'comment' => 'Valid comment',
        ];

        // ВИПРАВЛЕНО: put() та 'comment.create'
        $response = $this->actingAs($this->user)
            ->put(route('comment.create'), $data);

        $response->assertSessionHasErrors(['publication_id']);
    }

    #[Test]
    public function it_can_toggle_like_on_comment()
    {
        $comment = PublicationComment::factory()->create();

        // Тут залишаємо postJson, бо в роутах це POST
        $response = $this->actingAs($this->user)
            ->postJson(route('comment.like'), [
                'comment_id' => $comment->id
            ]);

        $response->assertStatus(200);
    }

    #[Test]
    public function it_fails_liking_non_existent_comment()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('comment.like'), [
                'comment_id' => 99999
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['comment_id']);
    }
}