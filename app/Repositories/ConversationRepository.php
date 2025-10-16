<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\Message;
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
        return $user->conversations()
            ->wherePivot('deleted_at', null)
            ->with(['participants' => function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id);
            }])
            ->with('lastMessage')
            ->withCount(['messages as unread_messages_count' => function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->latest('updated_at')
            ->get();
    }

    /**
     * @param User $currentUser
     * @param User $otherUser
     * @return null|Model
     */
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
     * @param User         $user
     * @param int          $limit
     * @return Collection
     */
    public function getMessages(Conversation $conversation, User $user, int $limit = 50):Collection
    {
        $pivot = $conversation->participants()->where('user_id', $user->id)->first()->pivot;
        $historyHiddenUntil = $pivot->history_hidden_until;
        $query = $conversation->messages();
        if ($historyHiddenUntil) {
            $query->where('created_at', '>', $historyHiddenUntil);
        }

        return $query->latest()->take($limit)->get()->reverse();
    }

    /**
     * @param User $user
     * @return int
     */
    public function getTotalUnreadCount(User $user): int
    {
        return Message::whereIn('conversation_id', $user->conversations()->pluck('id'))
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();
    }
}