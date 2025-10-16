<?php

namespace App\Repositories\Interfaces;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/** Interface ConversationRepository */
interface IConversationRepositoryInterface
{
    /**
     * @param User $user
     * @return Collection
     */
    public function getUserConversations(User $user): Collection;

    /**
     * @param User $currentUser
     * @param User $otherUser
     * @return Model|null
     */
    public function findForUsers(User $currentUser, User $otherUser): Model|null;

    /**
     * @param Conversation $conversation
     * @param int          $limit
     * @return Collection
     */
    public function getMessages(Conversation $conversation, int $limit = 50): Collection;
}