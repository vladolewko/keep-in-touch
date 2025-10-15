<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/** Interface ISubscriptionRepositoryInterface */
interface ISubscriptionRepositoryInterface
{
    /**
     * @param int $userId
     * @param int $subscribedToId
     * @return null|UserSubscription
     */
    public function findByUserIds(int $userId, int $subscribedToId): ?UserSubscription;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getFollowers(int $userId): Collection;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getSubscriptions(int $userId): Collection;

    /**
     * @param array $data
     * @return UserSubscription
     */
    public function create(array $data): UserSubscription;

    /**
     * @param UserSubscription $subscription
     * @return bool
     */
    public function delete(UserSubscription $subscription): bool;

    /**
     * @param UserSubscription $subscription
     * @return bool
     */
    public function accept(UserSubscription $subscription): bool;
}