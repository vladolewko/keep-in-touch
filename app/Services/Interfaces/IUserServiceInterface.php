<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/** Interface IUserServiceInterface */
interface IUserServiceInterface
{
    /**
     * @param string $access ('private' or 'public')
     * @return bool
     */
    public function changeProfileAccess(string $access): bool;

    /**
     * @param int $profileOwnerId
     * @return bool
     */
    public function hasAccessToProfile(int $profileOwnerId): bool;

    /**
     * @param int $userId
     * @return bool
     */
    public function blockUser(int $userId): bool;

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getSortedUsers(array $data): LengthAwarePaginator;

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAdminSortedUsers(array $data): LengthAwarePaginator;

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserPublications(User $user): Collection;

    /**
     * @param int $userId
     * @return User|null
     */
    public function findUserById(int $userId): ?User;

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfile(User $user, array $data): User;

    /**
     * @param int $userId
     * @return bool
     */
    public function toggleUserBlock(int $userId): bool;

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserReposts(User $user): Collection;
}
