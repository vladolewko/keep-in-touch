<?php

namespace App\Repositories;

use App\Models\Publication;
use App\Models\UserPublicationLike;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class PublicationRepository implements IPublicationRepositoryInterface
{
    public function all(bool $withTrashed = false): Collection
    {
        return $withTrashed ? Publication::withTrashed()->get() : Publication::all();
    }

    public function find(int $id, bool $withTrashed = false): ?Publication
    {
        try {
            return $withTrashed ? Publication::withTrashed()->find($id) : Publication::find($id);
        } catch (Exception $e) {
            return null;
        }
    }

    public function create(array $validated): Publication
    {
        try {
            $publication = Publication::create($validated);
        } catch (Exception $e) {
            throw new Exception('Error creating publication: ' . $e->getMessage());
        }
        return $publication;
    }

    public function update(int $publicationId, array $validated): bool
    {
        try {
            return $this->find($publicationId, true)?->update($validated) ?? false;
        } catch (Exception $e) {
            throw new Exception('Error updating publication: ' . $e->getMessage());
        }
    }

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

    public function restore(int $publicationId): bool
    {
        try {
            return $this->find($publicationId, true)?->restore() ?? false;
        } catch (Exception $e) {
            throw new Exception('Error restoring publication: ' . $e->getMessage());
        }
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Publication::query();
    }

    public function incrementLikes(int $publicationId): void
    {
        $publication = $this->find($publicationId, true);
        $publication?->increment('likes');
    }

    public function decrementLikes(int $publicationId): void
    {
        $publication = $this->find($publicationId, true);
        $publication?->decrement('likes');
    }

    public function getLikesCount(int $publicationId): int
    {
        return $this->find($publicationId, true)?->likes ?? 0;
    }

    public function hasUserLiked(int $publicationId, int $userId): bool
    {
        return UserPublicationLike::where('publication_id', $publicationId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function createLike(int $publicationId, int $userId): UserPublicationLike
    {
        return UserPublicationLike::create([
            'user_id' => $userId,
            'publication_id' => $publicationId
        ]);
    }

    public function deleteLike(int $publicationId, int $userId): bool
    {
        return UserPublicationLike::where('publication_id', $publicationId)
                ->where('user_id', $userId)
                ->delete() > 0;
    }
}