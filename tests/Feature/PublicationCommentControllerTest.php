<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\PublicationComment;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;

class PublicationCommentControllerTest extends AActionTest
{
    #[Test]
    public function userCanStoreComment(): void
    {
        $publication = Publication::factory()->create();
        $data = [
            'publication_id' => $publication->id,
            'comment' => 'This is a test comment',
        ];

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
    public function commentCreationFailsWithInvalidData(): void
    {
        $response = $this->actingAs($this->user)
            ->put(route('comment.create'), []);

        $response->assertSessionHasErrors(['publication_id', 'comment']);
    }

    #[Test]
    public function userCannotCommentOnNonExistentPublication(): void
    {
        $data = [
            'publication_id' => 999999,
            'comment' => 'Valid comment content',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('comment.create'), $data);

        $response->assertSessionHasErrors(['publication_id']);
    }

    #[Test]
    public function userCannotLikeNonExistentComment(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('comment.like'), [
                'comment_id' => 999999
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['comment_id']);
    }

    #[Test]
    public function userCannotLikeWithoutCommentId(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('comment.like'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['comment_id']);
    }

    #[Test]
    public function guestCannotStoreComment(): void
    {
        $publication = Publication::factory()->create();

        $response = $this->put(route('comment.create'), [
            'publication_id' => $publication->id,
            'comment' => 'Guest comment'
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function guestCannotLikeComment(): void
    {
        $comment = PublicationComment::factory()->create();

        $response = $this->postJson(route('comment.like'), [
            'comment_id' => $comment->id
        ]);

        $response->assertStatus(401);
    }
}