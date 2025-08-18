<?php

namespace Tests\Unit;

use App\Enums\MessageStatusEnum;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MessageServiceTest extends TestCase
{
    use RefreshDatabase;
    protected MessageService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new MessageService();
    }

    #[Test]
    public function is_create_message_with_valid_data()
    {
        $data = [
            'client_name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message',
        ];

        $message = $this->service->create($data);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'client_name' => $data['client_name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'status' => MessageStatusEnum::Pending->value,
        ]);
    }

    #[Test]
    public function is_changes_message_status()
    {
        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);

        $this->service->changeStatus($message, MessageStatusEnum::Processed);

        $this->assertEquals(MessageStatusEnum::Processed->value, $message->fresh()->status);
    }

    #[Test]
    public function is_assign_manager()
    {
        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
        $manager = User::factory()->create();
        $this->actingAs($manager);

        $this->service->assignManager($message, $manager->id);

        $this->assertEquals(1, $message->fresh()->manager_id);
    }

    #[Test]
    public function is_answer_message()
    {
        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
        $answer = 'Test answer';
        $manager = User::factory()->create();
        $this->actingAs($manager);

        $newMessage = $this->service->answer($message, $answer, $manager->id);
//        $message = $message->fresh();
        $this->assertEquals($answer, $newMessage->answer);
        $this->assertEquals($manager->id, $newMessage->manager_id);
        $this->assertEquals(MessageStatusEnum::Closed->value, $newMessage->status);
    }

    #[Test]
    public function is_throws_exception_when_creating_message_with_invalid_data()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid data');

        $this->service->create([
            'client_name' => '',
            'email' => '',
            'message' => '',
        ]);
    }

    #[Test]
    public function is_throws_exception_when_assinging_zero_manager()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid manager');

        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
        $managerId = 0;
        $this->service->assignManager($message, $managerId);
    }

    #[Test]
    public function is_throws_exception_when_assinging_invalid_manager()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Manager not found');

        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
//        $managerId = User::factory()->create()->id;
        $managerId = 9999; // Invalid manager ID
        $this->service->assignManager($message, $managerId);
    }


    #[Test]
    public function is_user_authorized(): void
    {
        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);

        $manager = User::factory()->create();

        $this->actingAs($manager);
        $this->service->assignManager($message, $manager->id);

        $this->assertEquals(auth()->user()->id, $manager->id);

    }

    #[Test]
    public function is_throws_exception_when_unauthorized_user_assign_message(): void
    {
        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);

        $manager = User::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($manager);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unauthorized action not allowed');

        $this->service->assignManager($message, $user->id);
    }

    #[Test]
    #[DataProvider('statusProvider')]
    public function it_can_change_status_to_any_enum_value(MessageStatusEnum $statusEnum): void
    {
        $message = Message::factory()->create();

        $this->service->changeStatus($message, $statusEnum);

        $this->assertEquals($statusEnum->value, $message->fresh()->status);
    }

    public static function statusProvider(): array
    {
        return [
            [MessageStatusEnum::Pending],
            [MessageStatusEnum::Processed],
            [MessageStatusEnum::Closed],
        ];
    }


    // Tests for answers
    #[Test]
    public function is_throws_exception_when_answer_message_with_invalid_data()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid data for answering message');

        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
        $answer = '';

        $this->service->answer($message, $answer, 1);

    }

    #[Test]
    public function is_throws_exception_when_answering_message_with_zero_manager()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid manager for answering message');

        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
        $answer = 'test answer';

        $this->service->answer($message, $answer, 0);

    }

    #[Test]
    public function is_throws_exception_when_answering_message_with_invalid_manager()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Manager not found');

        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);
        $answer = 'test answer';

        $this->service->answer($message, $answer, 9999);

    }

    #[Test]
    public function is_throws_exception_when_unauthorized_user_answer_message(): void
    {
        $message = Message::factory()->create([
            'status' => MessageStatusEnum::Pending->value,
        ]);

        $manager = User::factory()->create();
        $user = User::factory()->create();
        $answer = 'Test answer';

        $this->actingAs($manager);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unauthorized action not allowed');

        $this->service->answer($message, $answer, $user->id);
    }
}
