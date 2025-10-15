<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserPublicationRepost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/** Interface IRepostRepositoryInterface */
interface IRepostRepositoryInterface
{
    /**
     * @param int $publicationId
     * @param int $userId
     * @return null|UserPublicationRepost
     */
    public function find(int $publicationId, int $userId): ?UserPublicationRepost;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return UserPublicationRepost
     */
    public function create(int $publicationId, int $userId): UserPublicationRepost;

    /**
     * @param UserPublicationRepost $repost
     * @return bool
     */
    public function delete(UserPublicationRepost $repost): bool;
}