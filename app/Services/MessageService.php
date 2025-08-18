<?php

namespace App\Services;

use App\Enums\MessageStatusEnum;
use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function create(array $data)
    {
        if (empty($data['client_name']) || empty($data['email']) || empty($data['message'])) {
            throw new \InvalidArgumentException('Invalid data');
        }
        return Message::create([
            'client_name' => $data['client_name'],
            'email'       => $data['email'],
            'message'     => $data['message'],
            'status'      => MessageStatusEnum::Pending->value,
        ]);
    }

    public function changeStatus(Message $message, MessageStatusEnum $status)
    {
        $message->update([
            'status' => $status->value,
        ]);

        return $message;
    }

    public function assignManager(Message $message, int $managerId)
    {
        if (empty($managerId) || $managerId <= 0) {
            throw new \InvalidArgumentException('Invalid manager');
        }

        $user = User::find($managerId);
        if (empty($user)) {
            throw new \InvalidArgumentException('Manager not found');
        }

        if (auth()->user()->id !== $managerId) {
            throw new \InvalidArgumentException('Unauthorized action not allowed');
        }

        $message->update([
            'manager_id' => $managerId,
        ]);

        return $message;
    }

    public function answer(Message $message, string $answer, int $managerId)
    {
        if (empty($answer)) {
            throw new \InvalidArgumentException('Invalid data for answering message');
        }

        if (empty($managerId) || $managerId <= 0) {
            throw new \InvalidArgumentException('Invalid manager for answering message');
        }
        $user = User::find($managerId);
        if (empty($user)) {
            throw new \InvalidArgumentException('Manager not found');
        }

        if (auth()->user()->id !== $managerId) {
            throw new \InvalidArgumentException('Unauthorized action not allowed');
        }

        $message->update([
            'answer' => $answer,
            'manager_id' => $managerId,
            'status' => MessageStatusEnum::Closed->value,
        ]);

        return $message;
    }
}
