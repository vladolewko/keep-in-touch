<?php

namespace App\Repositories;

use App\Models\Publication;
use App\Models\UserPublicationLike;
use App\Repositories\Interfaces\IUserPublicationLikeRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserPublicationLikeRepository implements IUserPublicationLikeRepositoryInterface
{
    public function all(): Collection
    {
        return UserPublicationLike::all();
    }
    public function find(int $id): ?UserPublicationLike
    {
        try {
            return UserPublicationLike::find($id);
        } catch (Exception $e) {
            return null;
        }
    }
    public function exists(int $publicationId, int $userId): bool
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function create(int $publicationId, int $userId): UserPublicationLike
    {
        try {
            return UserPublicationLike::create([
                'publication_id' => $publicationId,
                'user_id' => $userId
            ]);
        } catch (Exception $e) {
            throw new Exception('Error creating like: ' . $e->getMessage());
        }
    }

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

    public function deleteById(int $id): bool
    {
        try {
            $like = $this->find($id);
            return $like ? $like->delete() : false;
        } catch (Exception $e) {
            throw new Exception('Error deleting like by id: ' . $e->getMessage());
        }
    }

    public function getByPublication(int $publicationId): Collection
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->with('user')
            ->get();
    }

    public function getByUser(int $userId): Collection
    {
        return UserPublicationLike::where('user_id', $userId)
            ->with('publication')
            ->get();
    }

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

    public function getPublicationIdsByUser(int $userId): array
    {
        return UserPublicationLike::where('user_id', $userId)
            ->pluck('publication_id')
            ->toArray();
    }

    public function getUserIdsByPublication(int $publicationId): array
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->pluck('user_id')
            ->toArray();
    }

    public function incrementPublicationLikes(int $publicationId): void
    {
        try {
            Publication::where('id', $publicationId)->increment('likes');
        } catch (Exception $e) {
            throw new Exception('Error incrementing likes: ' . $e->getMessage());
        }
    }

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

    public function getPublicationLikesCount(int $publicationId): int
    {
        return Publication::where('id', $publicationId)->value('likes') ?? 0;
    }

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

    public function deleteByPublication(int $publicationId): bool
    {
        try {
            return UserPublicationLike::where('publication_id', $publicationId)->delete() > 0;
        } catch (Exception $e) {
            throw new Exception('Error deleting likes by publication: ' . $e->getMessage());
        }
    }

    public function deleteByUser(int $userId): bool
    {
        try {
            return UserPublicationLike::where('user_id', $userId)->delete() > 0;
        } catch (Exception $e) {
            throw new Exception('Error deleting likes by user: ' . $e->getMessage());
        }
    }

    public function countByUser(int $userId): int
    {
        return UserPublicationLike::where('user_id', $userId)->count();
    }

    public function countByPublication(int $publicationId): int
    {
        return UserPublicationLike::where('publication_id', $publicationId)->count();
    }

    public function checkMultipleUsersLiked(int $publicationId, array $userIds): array
    {
        $likes = UserPublicationLike::where('publication_id', $publicationId)
            ->whereIn('user_id', $userIds)
            ->pluck('user_id')
            ->toArray();

        return array_map(fn($userId) => in_array($userId, $likes), $userIds);
    }

    public function getRecentByPublication(int $publicationId, int $limit = 10): Collection
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getPopularPublications(int $limit = 10, ?int $daysBack = null): Collection
    {
        $query = UserPublicationLike::with('publication')
            ->select('publication_id')
            ->selectRaw('COUNT(*) as likes_count');

        if ($daysBack) {
            $query->where('created_at', '>=', now()->subDays($daysBack));
        }

        return $query->groupBy('publication_id')
            ->orderBy('likes_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return UserPublicationLike::query();
    }
}