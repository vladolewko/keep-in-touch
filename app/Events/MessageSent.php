<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** Class MessageSent */
class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Message */
    public Message $message;

    /** @param Message $message */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /** @return PresenceChannel[] */
    public function broadcastOn(): array
    {
        return [new PresenceChannel('chat.'.$this->message->conversation_id)];
    }

    /** @return string */
    public function broadcastAs(): string
    {
        return 'new-message';
    }
}