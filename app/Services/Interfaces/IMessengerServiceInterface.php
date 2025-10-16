<?php

namespace App\Services\Interfaces;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ConversationRepository;

/** Interface MessengerService */
interface IMessengerServiceInterface
{
    /**
     * @param ConversationRepository $conversationRepository
     */
    public function __construct(ConversationRepository $conversationRepository);

    /**
     * @param Conversation $conversation
     * @param User         $user
     * @param array        $data
     * @return Message
     */
    public function sendMessage(Conversation $conversation, User $user, array $data): Message;

    /**
     * @param User $currentUser
     * @param User $otherUser
     * @return Conversation
     */
    public function startOrGetConversation(User $currentUser, User $otherUser): Conversation;

    /**
     * @param Conversation $conversation
     * @param User         $user
     * @param bool         $forBoth
     * @return void
     */
    public function deleteConversation(Conversation $conversation, User $user, bool $forBoth = false): void;

    /**
     * @param Conversation $conversation
     * @param User         $user
     * @return int
     */
    public function markAsRead(Conversation $conversation, User $user): int;

}