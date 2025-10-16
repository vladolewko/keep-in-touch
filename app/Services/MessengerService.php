<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ConversationRepository;

/** Class MessengerService */
class MessengerService
{
    protected ConversationRepository $conversationRepository;

    public function __construct(ConversationRepository $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }

    /**
     * @param Conversation $conversation
     * @param User         $user
     * @param array        $data
     * @return Message
     */
    public function sendMessage(Conversation $conversation, User $user, array $data): Message
    {
        $message = $conversation->messages()->create([
            'user_id' => $user->id,
            'body'    => $data['body'],
        ]);
        $message->load('user');

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    /**
     * @param User $currentUser
     * @param User $otherUser
     * @return Conversation
     */
    public function startOrGetConversation(User $currentUser, User $otherUser): Conversation
    {
        $conversation = $this->conversationRepository->findForUsers($currentUser, $otherUser);

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->participants()->attach([$currentUser->id, $otherUser->id]);
        }

        return $conversation;
    }
}