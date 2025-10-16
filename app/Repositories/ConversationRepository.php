<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\User;
use App\Repositories\Interfaces\IConversationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/** Class ConversationRepository */
class ConversationRepository implements IConversationRepositoryInterface
{
    /**
     * @param User $user
     * @return Collection
     */
    public function getUserConversations(User $user): Collection
    {
        return $user
            ->conversations()
            ->with([
                'participants' => function ($query) use ($user) {
                    $query->where('user_id', '!=', $user->id);
                },
            ])
            ->with('lastMessage')
            ->latest('updated_at')
            ->get();
    }

    public function findForUsers(User $currentUser, User $otherUser): Model|null
    {
        return $currentUser
            ->conversations()
            ->whereHas('participants', function ($query) use ($otherUser) {
                $query->where('user_id', $otherUser->id);
            })
            ->withCount('participants')
            ->having('participants_count', 2)
            ->first();
    }

    /**
     * @param Conversation $conversation
     * @param int          $limit
     * @return Collection
     */
    public function getMessages(Conversation $conversation, int $limit = 50): Collection
    {
        return $conversation->messages()->latest()->take($limit)->get()->reverse();
    }
}