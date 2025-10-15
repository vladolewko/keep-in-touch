<?php

namespace App\Services\Interfaces;

interface IUserPublicationLikeServiceInterface
{
    public function toggleLike(int $publicationId, int $userId): array;
    public function hasUserLiked(int $publicationId, int $userId): bool;
    public function getLikesCount(int $publicationId): int;
    public function getUsersWhoLiked(int $publicationId): array;
    public function getPublicationsLikedByUser(int $userId): array;
}