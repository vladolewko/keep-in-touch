<?php

namespace App\Repositories;

use App\Models\Publication;
use App\Models\UserPublicationLike;
use App\Repositories\Interfaces\IUserPublicationLikeRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Builder;

/** Class UserPublicationLikeRepository */
class UserPublicationLikeRepository implements IUserPublicationLikeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return UserPublicationLike::all();
    }

    /**
     * @param int $id
     * @return null|UserPublicationLike
     */
    public function find(int $id): ?UserPublicationLike
    {
        try {
            return UserPublicationLike::find($id);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function exists(int $publicationId, int $userId): bool
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return UserPublicationLike
     * @throws Exception
     */
    public function create(int $publicationId, int $userId): UserPublicationLike
    {
        try {
            return UserPublicationLike::create([
                'publication_id' => $publicationId,
                'user_id'        => $userId,
            ]);
        } catch (Exception $e) {
            throw new Exception('Error creating like: ' . $e->getMessage());
        }
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     * @throws Exception
     */
    public function delete(int $publicationId, int $userId): bool
    {
        try {
            return UserPublicationLike::where('publication_id', $publicationId)
                    ->where('user_id', $userId)
                    ->delete() > 0;
        } catch (Exception $e) {
            throw new Exception('Error deleting like: ' . $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteById(int $id): bool
    {
        try {
            $like = $this->find($id);
            return $like ? $like->delete() : false;
        } catch (Exception $e) {
            throw new Exception('Error deleting like by id: ' . $e->getMessage());
        }
    }

    /**
     * @param int $publicationId
     * @return Collection
     */
    public function getByPublication(int $publicationId): Collection
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->with('user')
            ->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getByUser(int $userId): Collection
    {
        return UserPublicationLike::where('user_id', $userId)
            ->with('publication')
            ->get();
    }

    /**
     * @param int $publicationId
     * @return array
     */
    public function getUsersByPublication(int $publicationId): array
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->with('user:id,name,email,avatar')
            ->get()
            ->pluck('user')
            ->filter()
            ->values()
            ->toArray();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getPublicationsByUser(int $userId): array
    {
        return UserPublicationLike::where('user_id', $userId)
            ->with('publication')
            ->get()
            ->pluck('publication')
            ->filter()
            ->values()
            ->toArray();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getPublicationIdsByUser(int $userId): array
    {
        return UserPublicationLike::where('user_id', $userId)
            ->pluck('publication_id')
            ->toArray();
    }

    /**
     * @param int $publicationId
     * @return array
     */
    public function getUserIdsByPublication(int $publicationId): array
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->pluck('user_id')
            ->toArray();
    }

    /**
     * @param int $publicationId
     * @return void
     * @throws Exception
     */
    public function incrementPublicationLikes(int $publicationId): void
    {
        try {
            Publication::where('id', $publicationId)->increment('likes');
        } catch (Exception $e) {
            throw new Exception('Error incrementing likes: ' . $e->getMessage());
        }
    }

    /**
     * @param int $publicationId
     * @return void
     * @throws Exception
     */
    public function decrementPublicationLikes(int $publicationId): void
    {
        try {
            Publication::where('id', $publicationId)
                ->where('likes', '>', 0)
                ->decrement('likes');
        } catch (Exception $e) {
            throw new Exception('Error decrementing likes: ' . $e->getMessage());
        }
    }

    /**
     * @param int $publicationId
     * @return int
     */
    public function getPublicationLikesCount(int $publicationId): int
    {
        return Publication::where('id', $publicationId)->value('likes') ?? 0;
    }

    /**
     * @param int $publicationId
     * @return bool
     * @throws Exception
     */
    public function syncPublicationLikesCount(int $publicationId): bool
    {
        try {
            $actualCount = $this->countByPublication($publicationId);
            return Publication::where('id', $publicationId)
                    ->update(['likes' => $actualCount]) > 0;
        } catch (Exception $e) {
            throw new Exception('Error syncing likes count: ' . $e->getMessage());
        }
    }

    /**
     * @param int $publicationId
     * @return bool
     * @throws Exception
     */
    public function deleteByPublication(int $publicationId): bool
    {
        try {
            return UserPublicationLike::where('publication_id', $publicationId)->delete() > 0;
        } catch (Exception $e) {
            throw new Exception('Error deleting likes by publication: ' . $e->getMessage());
        }
    }

    /**
     * @param int $userId
     * @return bool
     * @throws Exception
     */
    public function deleteByUser(int $userId): bool
    {
        try {
            return UserPublicationLike::where('user_id', $userId)->delete() > 0;
        } catch (Exception $e) {
            throw new Exception('Error deleting likes by user: ' . $e->getMessage());
        }
    }

    /**
     * @param int $userId
     * @return int
     */
    public function countByUser(int $userId): int
    {
        return UserPublicationLike::where('user_id', $userId)->count();
    }

    /**
     * @param int $publicationId
     * @return int
     */
    public function countByPublication(int $publicationId): int
    {
        return UserPublicationLike::where('publication_id', $publicationId)->count();
    }

    /**
     * @param int   $publicationId
     * @param array $userIds
     * @return array
     */
    public function checkMultipleUsersLiked(int $publicationId, array $userIds): array
    {
        $likes = UserPublicationLike::where('publication_id', $publicationId)
            ->whereIn('user_id', $userIds)
            ->pluck('user_id')
            ->toArray();

        return array_map(fn($userId) => in_array($userId, $likes), $userIds);
    }

    /**
     * @param int $publicationId
     * @param int $limit
     * @return Collection
     */
    public function getRecentByPublication(int $publicationId, int $limit = 10): Collection
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * @param int      $limit
     * @param null|int $daysBack
     * @return Collection
     */
    public function getPopularPublications(int $limit = 10, ?int $daysBack = null): Collection
    {
        $query = UserPublicationLike::with('publication')
            ->select('publication_id')
            ->selectRaw('COUNT(*) as likes_count');

        if ($daysBack) {
            $query->where('created_at', '>=', now()->subDays($daysBack));
        }

        return $query
            ->groupBy('publication_id')
            ->orderBy('likes_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return UserPublicationLike::query();
    }
}