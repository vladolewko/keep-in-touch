<?php

namespace App\Services\Interfaces;

/** Interface IUserPublicationLikeServiceInterface */
interface IUserPublicationLikeServiceInterface
{
    /**
     * @param int $publicationId
     * @param int $userId
     * @return array
     */
    public function toggleLike(int $publicationId, int $userId): array;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function hasUserLiked(int $publicationId, int $userId): bool;

    /**
     * @param int $publicationId
     * @return int
     */
    public function getLikesCount(int $publicationId): int;

    /**
     * @param int $publicationId
     * @return array
     */
    public function getUsersWhoLiked(int $publicationId): array;

    /**
     * @param int $userId
     * @return array
     */
    public function getPublicationsLikedByUser(int $userId): array;
}