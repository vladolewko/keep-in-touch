<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\Abstract\AActionTest;

class MessengerControllerTest extends AActionTest
{
    #[Test]
    public function userCanDisplayChatsIndexPage(): void
    {
        $conversation = Conversation::factory()->create();
        $conversation->participants()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->get(route('chats.index'));

        $response->assertStatus(200);
        $response->assertViewIs('chats.index');
        $response->assertViewHas('conversations');
    }

    #[Test]
    public function userCanShowConversationIfParticipant(): void
    {
        $otherUser = User::factory()->create();
        $conversation = Conversation::factory()->create();

        $conversation->participants()->attach([$this->user->id, $otherUser->id]);

        $response = $this->actingAs($this->user)
            ->get(route('chat.show', $conversation));

        $response->assertStatus(200);
        $response->assertViewIs('chats.show');
        $response->assertViewHas(['conversation', 'messages']);
    }

    #[Test]
    public function userCannotShowConversationIfNotParticipant(): void
    {
        $otherUser1 = User::factory()->create();
        $otherUser2 = User::factory()->create();

        $conversation = Conversation::factory()->create();
        $conversation->participants()->attach([$otherUser1->id, $otherUser2->id]);

        $response = $this->actingAs($this->user)
            ->get(route('chat.show', $conversation));

        $response->assertStatus(403);
    }

    #[Test]
    public function userCanStartOrGetConversationWithUser(): void
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->post(route('chat.start', $otherUser->id));

        $response->assertRedirect();
    }

    #[Test]
    public function userCanSendMessageInConversation(): void
    {
        $conversation = Conversation::factory()->create();
        $conversation->participants()->attach($this->user->id);

        $data = [
            'body' => 'Hello World!',
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('chat.send', $conversation), $data);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'body',
            'user_id',
            'created_at'
        ]);

        $response->assertJsonFragment([
            'body' => 'Hello World!',
            'conversation_id' => $conversation->id,
            'user_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function messengerValidatesMessageBody(): void
    {
        $conversation = Conversation::factory()->create();
        $conversation->participants()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->postJson(route('chat.send', $conversation), [
                'body' => ''
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['body']);
    }

    #[Test]
    public function userCannotSendMessageIfNotParticipant(): void
    {
        $conversation = Conversation::factory()->create();

        $response = $this->actingAs($this->user)
            ->postJson(route('chat.send', $conversation), [
                'body' => 'I am a hacker',
            ]);

        $response->assertStatus(403);
    }

    #[Test]
    public function userCanMarkConversationAsRead(): void
    {
        $conversation = Conversation::factory()->create();
        $conversation->participants()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->patchJson(route('chat.read', $conversation));

        $response->assertStatus(200);
        $response->assertJsonStructure(['total_unread']);
    }

    #[Test]
    public function userCanDeleteConversation(): void
    {
        $conversation = Conversation::factory()->create();
        $conversation->participants()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->delete(route('chat.destroy', $conversation));

        $response->assertRedirect(route('chats.index'));
        $response->assertSessionHas('status', 'Chat deleted successfully!');
    }

    #[Test]
    public function userCannotDeleteConversationIfNotParticipant(): void
    {
        $conversation = Conversation::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('chat.destroy', $conversation));

        $response->assertStatus(403);
    }
}