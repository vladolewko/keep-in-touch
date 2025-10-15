<?php

namespace App\Repositories\Interfaces;

use App\Models\UserPublicationLike;
use Illuminate\Database\Eloquent\Collection;

/** Interface IUserPublicationLikeRepositoryInterface */
interface IUserPublicationLikeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return null|UserPublicationLike
     */
    public function find(int $id): ?UserPublicationLike;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function exists(int $publicationId, int $userId): bool;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return UserPublicationLike
     */
    public function create(int $publicationId, int $userId): UserPublicationLike;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function delete(int $publicationId, int $userId): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $publicationId
     * @return Collection
     */
    public function getByPublication(int $publicationId): Collection;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getByUser(int $userId): Collection;

    /**
     * @param int $publicationId
     * @return array
     */
    public function getUsersByPublication(int $publicationId): array;

    /**
     * @param int $userId
     * @return array
     */
    public function getPublicationsByUser(int $userId): array;

    /**
     * @param int $userId
     * @return array
     */
    public function getPublicationIdsByUser(int $userId): array;

    /**
     * @param int $publicationId
     * @return array
     */
    public function getUserIdsByPublication(int $publicationId): array;

    /**
     * @param int $publicationId
     * @return void
     */
    public function incrementPublicationLikes(int $publicationId): void;

    /**
     * @param int $publicationId
     * @return void
     */
    public function decrementPublicationLikes(int $publicationId): void;

    /**
     * @param int $publicationId
     * @return int
     */
    public function getPublicationLikesCount(int $publicationId): int;

    /**
     * @param int $publicationId
     * @return bool
     */
    public function syncPublicationLikesCount(int $publicationId): bool;

    /**
     * @param int $publicationId
     * @return bool
     */
    public function deleteByPublication(int $publicationId): bool;

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteByUser(int $userId): bool;

    /**
     * @param int $userId
     * @return int
     */
    public function countByUser(int $userId): int;

    /**
     * @param int $publicationId
     * @return int
     */
    public function countByPublication(int $publicationId): int;

    /**
     * @param int   $publicationId
     * @param array $userIds
     * @return array
     */
    public function checkMultipleUsersLiked(int $publicationId, array $userIds): array;

    /**
     * @param int $publicationId
     * @param int $limit
     * @return Collection
     */
    public function getRecentByPublication(int $publicationId, int $limit = 10): Collection;

    /**
     * @param int      $limit
     * @param null|int $daysBack
     * @return Collection
     */
    public function getPopularPublications(int $limit = 10, ?int $daysBack = null): Collection;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): \Illuminate\Database\Eloquent\Builder;
}