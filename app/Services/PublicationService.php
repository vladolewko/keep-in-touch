<?php

namespace App\Services;

use App\Enums\NotificationTopicEnum;
use App\Models\Publication;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Repositories\Interfaces\ICommentRepositoryInterface;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Repositories\Interfaces\IRepostRepositoryInterface;
use App\Services\Interfaces\IPublicationServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/** Class PublicationService */
class PublicationService implements IPublicationServiceInterface
{
    /**
     * @param IPublicationRepositoryInterface $publicationRepository
     * @param IRepostRepositoryInterface      $repostRepository
     * @param ICommentRepositoryInterface     $commentRepository
     */
    public function __construct(
        private readonly IPublicationRepositoryInterface $publicationRepository,
        private readonly IRepostRepositoryInterface      $repostRepository,
        private readonly ICommentRepositoryInterface     $commentRepository,
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
        $perPage = min((int)($parameters['per_page'] ?? 10), 100);

        $query = $this->publicationRepository->query();
        if ($withTrashed) {
            $query::withTrashed();
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
    public function find(int $id, bool $withTrashed = false): ?Model
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
    public function delete(int $publicationId, bool $isForce = false): ?bool
    {
        return $this->publicationRepository->delete($publicationId, $isForce);
    }

    /**
     * @param Publication $publication
     * @return void
     */
    public function toggleStatus(Publication $publication): void
    {
        if ($publication->trashed()) {
            $publication->restore();
        } else {
            $publication->delete();
        }
    }

    /**
     * @param int $publicationId
     * @return bool
     */
    public function restore(int $publicationId): bool
    {
        return $this->publicationRepository->restore($publicationId);
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return array
     * @throws Throwable
     */
    public function toggleLike(int $publicationId, int $userId): array
    {
        DB::beginTransaction();
        try {
            $publication = $this->publicationRepository->find($publicationId);

            if (!$publication) {
                throw new Exception('Publication not found');
            }

            $liker     = User::find($userId);
            $postOwner = $publication->user;
            $hasLiked  = $this->publicationRepository->hasUserLiked($publicationId, $userId);

            if ($hasLiked) {
                $this->publicationRepository->deleteLike($publicationId, $userId);
                $this->publicationRepository->decrementLikes($publicationId);
                $isLiked = false;
            } else {
                $this->publicationRepository->createLike($publicationId, $userId);
                $this->publicationRepository->incrementLikes($publicationId);
                $isLiked = true;

                if ($postOwner && $liker && $postOwner->id !== $liker->id) {
                    $postOwner->notify(
                        new DatabaseNotification(
                            topic: NotificationTopicEnum::LIKE,
                            sender: $liker,
                            contextData: [
                                'item_type'  => 'publication',
                                'item_id'    => $publicationId,
                                'post_title' => $publication->title ?? 'публікацію',
                            ],
                        ),
                    );
                }
            }

            DB::commit();

            return [
                'success'     => true,
                'liked'       => $isLiked,
                'likes_count' => $this->publicationRepository->getLikesCount($publicationId),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return bool
     */
    public function hasUserLiked(int $publicationId, int $userId): bool
    {
        return $this->publicationRepository->hasUserLiked($publicationId, $userId);
    }

    /**
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
     * @param Builder     $query
     * @param null|string $search
     * @return Builder
     */
    private function applySearch(Builder $query, ?string $search): Builder
    {
        if ($search && trim($search) !== '') {
            $searchTerm = trim($search);

            $query->where(function ($q) use ($searchTerm) {
                $q
                    ->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query;
    }

    /**
     * @param Builder     $query
     * @param null|string $filter
     * @return Builder
     */
    private function applySubscriptionFilter(Builder $query, ?string $filter): Builder
    {
        if ($filter === 'subscriptions' && auth()->check()) {
            $query->whereIn('user_id', function ($subQuery) {
                $subQuery
                    ->select('subscribed_to_id')
                    ->from('user_subscriptions')
                    ->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function destroy(int $id): bool
    {
        return $this->delete($id, true);
    }

    /**
     * @param int $publicationId
     * @param int $userId
     * @return array
     * @throws Throwable
     */
    public function toggleRepost(int $publicationId, int $userId): array
    {
        $publication = $this->publicationRepository->findById($publicationId);
        if (!$publication) {
            throw new \Exception('Publication not found.');
        }

        DB::beginTransaction();
        try {
            $existingRepost = $this->repostRepository->find($publicationId, $userId);
            $isReposted     = false;

            if ($existingRepost) {
                $this->repostRepository->delete($existingRepost);
                $publication->decrement('reposts');
            } else {
                $this->repostRepository->create($publicationId, $userId);
                $publication->increment('reposts');
                $isReposted = true;
            }

            DB::commit();

            return [
                'reposted'      => $isReposted,
                'reposts_count' => $publication->reposts,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Repost Error: ' . $e->getMessage());
            throw $e;
        }
    }
}