<?php

namespace App\Events;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** Class MessagesRead */
class MessagesRead implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /** @var int */
    public int $conversationId;

    /** @param int $conversationId */
    public function __construct(int $conversationId)
    {
        $this->conversationId = $conversationId;
    }

    /** @return PresenceChannel[] */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat.' . $this->conversationId),
        ];
    }

    /** @return string */
    public function broadcastAs(): string
    {
        return 'messages-read';
    }
}