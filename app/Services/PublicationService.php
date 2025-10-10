<?php

namespace App\Services;

use App\Models\Publication;
use App\Models\UserSubscription;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Services\Interfaces\IPublicationServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/** Class PublicationService */
class PublicationService implements IPublicationServiceInterface
{
    /**
     * @param IPublicationRepositoryInterface $publicationRepository
     */
    public function __construct(
        protected IPublicationRepositoryInterface $publicationRepository,
    ) {}

    /**
     * @param array $parameters
     * @param bool  $withTrashed
     * @return LengthAwarePaginator
     */
    public function all(array $parameters = [], bool $withTrashed = false): LengthAwarePaginator
    {
        $search  = $parameters['search'] ?? null;
        $filter  = $parameters['filter'] ?? null;
        $sort    = $parameters['sort'] ?? 'newest';
        $perPage = min((int)($parameters['per_page'] ?? 10), 100); // Limit max per page

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

    /**
     * @param int  $id
     * @param bool $withTrashed
     * @return null|Model
     */
    public function find(int $id, bool $withTrashed = false): null | Model
    {
        return $this->publicationRepository->find($id, $withTrashed);
    }

    /**
     * @param array $validated
     * @return Publication
     * @throws Exception
     */
    public function create(array $validated): Publication
    {
        return $this->publicationRepository->create($validated);
    }

    /**
     * @param int   $publicationId
     * @param array $validated
     * @return bool
     * @throws Exception
     */
    public function update(int $publicationId, array $validated): bool
    {
        return $this->publicationRepository->update($publicationId, $validated);
    }

    /**
     * @param int  $publicationId
     * @param bool $isForce
     * @return null|bool
     * @throws Exception
     */
    public function delete(int $publicationId, bool $isForce = false): null | bool
    {
        return $this->publicationRepository->delete($publicationId, $isForce);
    }

    /**
     * Apply sorting to the query based on parameter
     * @param Builder $query
     * @param string  $parameter
     * @return Builder
     */
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

    /**
     * Filter out current user's publications
     * @param Builder $query
     * @return Builder
     */
    private function applyUserFilter(Builder $query): Builder
    {
        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        return $query;
    }

    /**
     * Apply search filter to title and description
     * @param Builder     $query
     * @param null|string $search
     * @return Builder
     */
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

    /**
     * Filter publications by user subscriptions using optimized query
     * @param Builder     $query
     * @param null|string $filter
     * @return Builder
     */
    private function applySubscriptionFilter(Builder $query, ?string $filter): Builder
    {
        if ($filter === 'subscriptions' && auth()->check()) {
            // Optimized: Use whereIn with subquery instead of pluck
            $query->whereIn('user_id', function ($subQuery) {
                $subQuery->select('subscribed_to_id')
                    ->from('user_subscriptions')
                    ->where('user_id', auth()->id());
            });
        }

        return $query;
    }
}