<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepositoryInterface;
use App\Services\Interfaces\ISubscriptionServiceInterface;
use App\Services\Interfaces\IUserServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/** Class UserService */
class UserService implements IUserServiceInterface
{
    /**
     * @param IUserRepositoryInterface      $userRepository
     * @param ISubscriptionServiceInterface $subscriptionService
     */
    public function __construct(
        protected IUserRepositoryInterface      $userRepository,
        protected ISubscriptionServiceInterface $subscriptionService,
    ) {}

    /**
     * @param int $userId
     * @return null|User
     */
    public function findUserById(int $userId): ?User
    {
        return User::withTrashed()->find($userId);
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserReposts(User $user): Collection
    {
        $reposts = $this->userRepository->getReposts($user);

        $reposts->each(function ($repost) {
            $currentUserId       = auth()->id();
            $repost->is_liked    = $repost->likes()->where('user_id', $currentUserId)->exists();
            $repost->is_reposted = $repost->reposts()->where('user_id', $currentUserId)->exists();
        });

        return $reposts;
    }

    /**
     * @param User  $user
     * @param array $data
     * @return User
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateProfile(User $user, array $data): User
    {
        if (isset($data['remove_image'])) {
            $user->clearMediaCollection('profile_images');
            return $user;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if (isset($data['profile_image'])) {
            $user
                ->addMedia($data['profile_image'])
                ->toMediaCollection('profile_images');
        }

        $user->save();
        return $user;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function toggleUserBlock(int $userId): bool
    {
        $user = $this->findUserById($userId);
        if (!$user) {
            return false;
        }

        if ($user->trashed()) {
            return $user->restore();
        }
        return $user->delete();
    }

    /**
     * @param string $access
     * @return bool
     */
    public function changeProfileAccess(string $access): bool
    {
        $isPrivate = ($access === 'private') ? 1 : 0;
        return $this->userRepository->update(Auth::id(), ['is_private' => $isPrivate]);
    }

    /**
     * @param int $profileOwnerId
     * @return bool
     */
    public function hasAccessToProfile(int $profileOwnerId): bool
    {
        $user = $this->userRepository->findById($profileOwnerId);

        if (!$user) {
            return false;
        }

        if ($user->is_private === 0) {
            return true;
        }

        $subscriptionStatus = $this->subscriptionService->checkSubscriptionStatus(Auth::id(), $profileOwnerId);

        return $subscriptionStatus === true;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function blockUser(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getSortedUsers(array $data): LengthAwarePaginator
    {
        return $this->userRepository->sortUsers(
            $data['parameter'] ?? null,
            $data['search'] ?? null,
        );
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAdminSortedUsers(array $data): LengthAwarePaginator
    {
        return $this->userRepository->adminSortUsers(
            $data['parameter'] ?? null,
            $data['search'] ?? null,
            $data['filter'] ?? null,
        );
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserPublications(User $user): Collection
    {
        $publications = $this->userRepository->getPublications($user);

        $publications->each(function ($publication) {
            $currentUserId              = Auth::id();
            $publication->is_liked      = $publication->likes()->where('user_id', $currentUserId)->exists();
            $publication->is_reposted   = $publication->reposts()->where('user_id', $currentUserId)->exists();
            $publication->commentsCount = $publication->comments->count();

            $publication->comments->each(function ($comment) use ($currentUserId) {
                $comment->nickname = $comment->user->nickname;
                $comment->is_liked = $comment->likes()->where('user_id', $currentUserId)->exists();
            });
        });

        return $publications;
    }
}