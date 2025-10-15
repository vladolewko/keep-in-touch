<?php

namespace App\Repositories\Interfaces;

use App\Models\UserPublicationLike;
use Illuminate\Database\Eloquent\Collection;

interface IUserPublicationLikeRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?UserPublicationLike;
    public function exists(int $publicationId, int $userId): bool;
    public function create(int $publicationId, int $userId): UserPublicationLike;
    public function delete(int $publicationId, int $userId): bool;
    public function deleteById(int $id): bool;
    public function getByPublication(int $publicationId): Collection;
    public function getByUser(int $userId): Collection;
    public function getUsersByPublication(int $publicationId): array;
    public function getPublicationsByUser(int $userId): array;
    public function getPublicationIdsByUser(int $userId): array;
    public function getUserIdsByPublication(int $publicationId): array;
    public function incrementPublicationLikes(int $publicationId): void;
    public function decrementPublicationLikes(int $publicationId): void;
    public function getPublicationLikesCount(int $publicationId): int;
    public function syncPublicationLikesCount(int $publicationId): bool;
    public function deleteByPublication(int $publicationId): bool;
    public function deleteByUser(int $userId): bool;
    public function countByUser(int $userId): int;
    public function countByPublication(int $publicationId): int;
    public function checkMultipleUsersLiked(int $publicationId, array $userIds): array;
    public function getRecentByPublication(int $publicationId, int $limit = 10): Collection;
    public function getPopularPublications(int $limit = 10, ?int $daysBack = null): Collection;
    public function query(): \Illuminate\Database\Eloquent\Builder;
}