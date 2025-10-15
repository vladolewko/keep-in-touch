<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/** Interface ISubscriptionServiceInterface */
interface ISubscriptionServiceInterface
{
    /**
     * @param int $userId
     * @return array
     */
    public function getFollowersData(int $userId): array;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getSubscriptionsData(int $userId): Collection;

    /**
     * @param int    $followerId
     * @param string $action
     * @return void
     */
    public function manageFollowerRequest(int $followerId, string $action): void;

    /**
     * @param int $subscribedToId
     * @return void
     */
    public function toggleSubscription(int $subscribedToId): void;

    /**
     * @param int $userId
     * @param int $subscribedToId
     * @return bool|string
     */
    public function checkSubscriptionStatus(int $userId, int $subscribedToId): bool|string;
}
