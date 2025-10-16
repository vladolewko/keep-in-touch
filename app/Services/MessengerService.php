<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Events\MessagesRead;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Repositories\ConversationRepository;
use App\Services\Interfaces\IMessengerServiceInterface;

/** Class MessengerService */
class MessengerService implements IMessengerServiceInterface
{
    /** @param ConversationRepository $conversationRepository */
    public function __construct(protected ConversationRepository $conversationRepository) {}

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

        $recipient = $conversation->participants()->where('user_id', '!=', $user->id)->first();
        if ($recipient) {
            $conversation->participants()->updateExistingPivot($recipient->id, [
                'deleted_at' => null,
            ]);
        }

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

    /**
     * @param Conversation $conversation
     * @param User         $user
     * @param bool         $forBoth
     * @return void
     */
    public function deleteConversation(Conversation $conversation, User $user, bool $forBoth = false): void
    {
        if ($forBoth) {
            $conversation->delete();
        } else {
            $timestamp = now();
            $conversation->participants()->updateExistingPivot($user->id, [
                'deleted_at'           => $timestamp,
                'history_hidden_until' => $timestamp,
            ]);
        }
    }

    /**
     * @param Conversation $conversation
     * @param User         $user
     * @return int
     */
    public function markAsRead(Conversation $conversation, User $user): int
    {
        $conversation
            ->messages()
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        broadcast(new MessagesRead($conversation->id))->toOthers();

        return $this->conversationRepository->getTotalUnreadCount($user);
    }
}