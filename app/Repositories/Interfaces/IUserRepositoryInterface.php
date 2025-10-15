<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/** Interface IUserRepositoryInterface */
interface IUserRepositoryInterface
{
    /**
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User;

    /**
     * @param User $user
     * @return Collection
     */
    public function getReposts(User $user): Collection;

    /**
     * @return Collection
     */
    public function getSubscriptionRequests(): Collection;

    /**
     * @param User $user
     * @return Collection
     */
    public function getPublications(User $user): Collection;

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function sortUsers(string $parameter = null, string $search = null): LengthAwarePaginator;

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @param string|null $filter
     * @return LengthAwarePaginator
     */
    public function adminSortUsers(string $parameter = null, string $search = null, string $filter = null): LengthAwarePaginator;

    /**
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function update(int $userId, array $data): bool;

    /**
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool;
}