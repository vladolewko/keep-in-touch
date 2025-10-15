<?php

namespace App\Services;

use App\Models\Publication;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Services\Interfaces\IPublicationServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PublicationService implements IPublicationServiceInterface
{
    public function __construct(
        protected IPublicationRepositoryInterface $publicationRepository,
    ) {}

    public function all(array $parameters = [], bool $withTrashed = false): LengthAwarePaginator
    {
        $search  = $parameters['search'] ?? null;
        $filter  = $parameters['filter'] ?? null;
        $sort    = $parameters['sort'] ?? 'newest';
        $perPage = min((int)($parameters['per_page'] ?? 10), 100);

        $query = $this->publicationRepository->query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        $query = $this->applyUserFilter($query);
        $query = $this->applySearch($query, $search);
        $query = $this->applySubscriptionFilter($query, $filter);
        $query = $this->applySorting($query, $sort);

        return $query->paginate($perPage);
    }

    public function find(int $id, bool $withTrashed = false): ?Model
    {
        return $this->publicationRepository->find($id, $withTrashed);
    }

    public function create(array $validated): Publication
    {
        return $this->publicationRepository->create($validated);
    }

    public function update(int $publicationId, array $validated): bool
    {
        return $this->publicationRepository->update($publicationId, $validated);
    }

    public function delete(int $publicationId, bool $isForce = false): ?bool
    {
        return $this->publicationRepository->delete($publicationId, $isForce);
    }

    public function toggleStatus(Publication $publication): void
    {
        if ($publication->trashed()) {
            $publication->restore();
        } else {
            $publication->delete();
        }
    }

    public function restore(int $publicationId): bool
    {
        return $this->publicationRepository->restore($publicationId);
    }

    /**
     * Toggle like for a publication
     *
     * @param int $publicationId
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function toggleLike(int $publicationId, int $userId): array
    {
        DB::beginTransaction();
        try {
            $publication = $this->publicationRepository->find($publicationId);

            if (!$publication) {
                throw new Exception('Publication not found');
            }

            $hasLiked = $this->publicationRepository->hasUserLiked($publicationId, $userId);

            if ($hasLiked) {
                $this->publicationRepository->deleteLike($publicationId, $userId);
                $this->publicationRepository->decrementLikes($publicationId);
                $isLiked = false;
            } else {
                $this->publicationRepository->createLike($publicationId, $userId);
                $this->publicationRepository->incrementLikes($publicationId);
                $isLiked = true;
            }

            DB::commit();

            return [
                'success' => true,
                'liked' => $isLiked,
                'likes_count' => $this->publicationRepository->getLikesCount($publicationId)
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Check if user has liked a publication
     */
    public function hasUserLiked(int $publicationId, int $userId): bool
    {
        return $this->publicationRepository->hasUserLiked($publicationId, $userId);
    }

    private function applySorting(Builder $query, string $parameter): Builder
    {
        $sortMapping = [
            'likes ASC'    => ['likes', 'asc'],
            'likes DESC'   => ['likes', 'desc'],
            'reposts ASC'  => ['reposts', 'asc'],
            'reposts DESC' => ['reposts', 'desc'],
            'newest'       => ['updated_at', 'desc'],
            'oldest'       => ['updated_at', 'asc'],
            'id ASC'       => ['id', 'asc'],
            'id DESC'      => ['id', 'desc'],
        ];

        [$column, $direction] = $sortMapping[$parameter] ?? ['updated_at', 'desc'];

        return $query->orderBy($column, $direction);
    }

    private function applyUserFilter(Builder $query): Builder
    {
        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        return $query;
    }

    private function applySearch(Builder $query, ?string $search): Builder
    {
        if ($search && trim($search) !== '') {
            $searchTerm = trim($search);

            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query;
    }

    private function applySubscriptionFilter(Builder $query, ?string $filter): Builder
    {
        if ($filter === 'subscriptions' && auth()->check()) {
            $query->whereIn('user_id', function ($subQuery) {
                $subQuery->select('subscribed_to_id')
                    ->from('user_subscriptions')
                    ->where('user_id', auth()->id());
            });
        }

        return $query;
    }
}