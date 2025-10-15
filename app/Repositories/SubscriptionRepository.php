<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSubscription;
use App\Repositories\Interfaces\ISubscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/** Class SubscriptionRepository */
class SubscriptionRepository implements ISubscriptionRepositoryInterface
{
    /**
     * @param int $userId
     * @param int $subscribedToId
     * @return null|UserSubscription
     */
    public function findByUserIds(int $userId, int $subscribedToId): ?UserSubscription
    {
        return UserSubscription::where('user_id', $userId)
            ->where('subscribed_to_id', $subscribedToId)
            ->first();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getFollowers(int $userId): Collection
    {
        $followerIds = UserSubscription::where('subscribed_to_id', $userId)
            ->where('is_accepted', 1)
            ->pluck('user_id');

        return User::whereIn('id', $followerIds)->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getSubscriptions(int $userId): Collection
    {
        $subscriptionIds = UserSubscription::where('user_id', $userId)
            ->where('is_accepted', 1)
            ->pluck('subscribed_to_id');

        return User::whereIn('id', $subscriptionIds)->get();
    }

    /**
     * @param array $data
     * @return UserSubscription
     */
    public function create(array $data): UserSubscription
    {
        return UserSubscription::create($data);
    }

    /**
     * @param UserSubscription $subscription
     * @return bool
     */
    public function delete(UserSubscription $subscription): bool
    {
        return $subscription->delete();
    }

    /**
     * @param UserSubscription $subscription
     * @return bool
     */
    public function accept(UserSubscription $subscription): bool
    {
        return $subscription->update(['is_accepted' => 1]);
    }
}