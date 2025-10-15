<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserPublicationLikeRepositoryInterface;
use App\Services\Interfaces\IUserPublicationLikeServiceInterface;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class UserPublicationLikeService implements IUserPublicationLikeServiceInterface
{
    public function __construct(
        protected IUserPublicationLikeRepositoryInterface $likeRepository
    ) {}

    public function toggleLike(int $publicationId, int $userId): array
    {
        DB::beginTransaction();
        try {
            $hasLiked = $this->likeRepository->exists($publicationId, $userId);

            if ($hasLiked) {
                $this->likeRepository->delete($publicationId, $userId);
                $this->likeRepository->decrementPublicationLikes($publicationId);
                $isLiked = false;
                $message = 'Publication unliked successfully';
            } else {
                $this->likeRepository->create($publicationId, $userId);
                $this->likeRepository->incrementPublicationLikes($publicationId);
                $isLiked = true;
                $message = 'Publication liked successfully';
            }

            DB::commit();

            return [
                'success' => true,
                'message' => $message,
                'liked' => $isLiked,
                'likes_count' => $this->likeRepository->getPublicationLikesCount($publicationId)
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Toggle Like Error: ' . $e->getMessage());
            throw new Exception('Error toggling like: ' . $e->getMessage());
        }
    }

    public function hasUserLiked(int $publicationId, int $userId): bool
    {
        return $this->likeRepository->exists($publicationId, $userId);
    }

    public function getLikesCount(int $publicationId): int
    {
        return $this->likeRepository->getPublicationLikesCount($publicationId);
    }

    public function getUsersWhoLiked(int $publicationId): array
    {
        return $this->likeRepository->getUsersByPublication($publicationId);
    }

    public function getPublicationsLikedByUser(int $userId): array
    {
        return $this->likeRepository->getPublicationsByUser($userId);
    }

    public function getPublicationIdsLikedByUser(int $userId): array
    {
        return $this->likeRepository->getPublicationIdsByUser($userId);
    }

    public function removeAllLikesForPublication(int $publicationId): bool
    {
        DB::beginTransaction();
        try {
            $this->likeRepository->deleteByPublication($publicationId);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Remove All Likes Error: ' . $e->getMessage());
            throw new Exception('Error removing likes: ' . $e->getMessage());
        }
    }

    public function removeAllLikesByUser(int $userId): bool
    {
        DB::beginTransaction();
        try {
            $publicationIds = $this->likeRepository->getPublicationIdsByUser($userId);
            $this->likeRepository->deleteByUser($userId);

            foreach ($publicationIds as $publicationId) {
                $this->likeRepository->syncPublicationLikesCount($publicationId);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Remove User Likes Error: ' . $e->getMessage());
            throw new Exception('Error removing user likes: ' . $e->getMessage());
        }
    }

    public function getRecentLikes(int $publicationId, int $limit = 10): array
    {
        return $this->likeRepository->getRecentByPublication($publicationId, $limit)->toArray();
    }

    public function getUserTotalLikes(int $userId): int
    {
        return $this->likeRepository->countByUser($userId);
    }

    public function getPopularPublications(int $limit = 10, ?int $daysBack = null): array
    {
        return $this->likeRepository->getPopularPublications($limit, $daysBack)->toArray();
    }

    public function syncLikesCount(int $publicationId): bool
    {
        try {
            return $this->likeRepository->syncPublicationLikesCount($publicationId);
        } catch (Exception $e) {
            Log::error('Sync Likes Count Error: ' . $e->getMessage());
            throw new Exception('Error syncing likes count: ' . $e->getMessage());
        }
    }

    public function checkMultipleLiked(array $publicationIds, int $userId): array
    {
        $result = [];
        foreach ($publicationIds as $publicationId) {
            $result[$publicationId] = $this->likeRepository->exists($publicationId, $userId);
        }
        return $result;
    }
}