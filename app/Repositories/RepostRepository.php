<?php

namespace App\Repositories;

use App\Models\UserPublicationRepost;
use App\Repositories\Interfaces\IRepostRepositoryInterface;

/** Class RepostRepository */
class RepostRepository implements IRepostRepositoryInterface
{
    /**
     * @param int $publicationId
     * @param int $userId
     * @return null|UserPublicationRepost
     */
    public function find(int $publicationId, int $userId): ?UserPublicationRepost
    {
        return UserPublicationRepost::where('user_id', $userId)
            ->where('publication_id', $publicationId)
            ->first();
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return UserPublicationRepost
     */
    public function create(int $publicationId, int $userId): UserPublicationRepost
    {
        return UserPublicationRepost::create([
            'user_id'        => $userId,
            'publication_id' => $publicationId,
        ]);
    }

    /**
     * @param UserPublicationRepost $repost
     * @return bool
     */
    public function delete(UserPublicationRepost $repost): bool
    {
        return $repost->delete();
    }
}