<?php

namespace App\Repositories;

use App\Models\Publication;
use App\Models\UserPublicationLike;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/** Class PublicationRepository */
class PublicationRepository implements IPublicationRepositoryInterface
{
    /**
     * @param bool $withTrashed
     * @return Collection
     */
    public function all(bool $withTrashed = false): Collection
    {
        return $withTrashed ? Publication::withTrashed()->get() : Publication::all();
    }

    /**
     * @param int  $id
     * @param bool $withTrashed
     * @return null|Publication
     */
    public function find(int $id, bool $withTrashed = false): ?Publication
    {
        try {
            return $withTrashed ? Publication::withTrashed()->find($id) : Publication::find($id);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param array $validated
     * @return Publication
     * @throws Exception
     */
    public function create(array $validated): Publication
    {
        try {
            $publication = Publication::create($validated);
        } catch (Exception $e) {
            throw new Exception('Error creating publication: ' . $e->getMessage());
        }
        return $publication;
    }

    /**
     * @param int   $publicationId
     * @param array $validated
     * @return bool
     * @throws Exception
     */
    public function update(int $publicationId, array $validated): bool
    {
        try {
            return $this->find($publicationId, true)?->update($validated) ?? false;
        } catch (Exception $e) {
            throw new Exception('Error updating publication: ' . $e->getMessage());
        }
    }

    /**
     * @param int  $publicationId
     * @param bool $isForce
     * @return bool
     * @throws Exception
     */
    public function delete(int $publicationId, bool $isForce = false): bool
    {
        try {
            $publication = $this->find($publicationId, true);

            if (!$publication) {
                return false;
            }

            if ($isForce) {
                $publication->media()->delete();
                $publication->forceDelete();
            } else {
                $publication->delete();
            }

            return true;
        } catch (Exception $e) {
            throw new Exception('Error deleting publication: ' . $e->getMessage());
        }
    }

    /**
     * @param int $publicationId
     * @return bool
     * @throws Exception
     */
    public function restore(int $publicationId): bool
    {
        try {
            return $this->find($publicationId, true)?->restore() ?? false;
        } catch (Exception $e) {
            throw new Exception('Error restoring publication: ' . $e->getMessage());
        }
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Publication::query()->with('comments')->with('likes');
    }

    /**
     * @param int $publicationId
     * @return void
     */
    public function incrementLikes(int $publicationId): void
    {
        $publication = $this->find($publicationId, true);
        $publication?->increment('likes');
    }

    /**
     * @param int $publicationId
     * @return void
     */
    public function decrementLikes(int $publicationId): void
    {
        $publication = $this->find($publicationId, true);
        $publication?->decrement('likes');
    }

    /**
     * @param int $publicationId
     * @return int
     */
    public function getLikesCount(int $publicationId): int
    {
        return $this->find($publicationId, true)?->likes ?? 0;
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function hasUserLiked(int $publicationId, int $userId): bool
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return UserPublicationLike
     */
    public function createLike(int $publicationId, int $userId): UserPublicationLike
    {
        return UserPublicationLike::create([
            'user_id'        => $userId,
            'publication_id' => $publicationId,
        ]);
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function deleteLike(int $publicationId, int $userId): bool
    {
        return UserPublicationLike::where('publication_id', $publicationId)
                ->where('user_id', $userId)
                ->delete() > 0;
    }
}