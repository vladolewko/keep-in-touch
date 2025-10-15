<?php

namespace App\Services;

use App\Repositories\Interfaces\ISubscriptionRepositoryInterface;
use App\Repositories\Interfaces\IUserRepositoryInterface;
use App\Services\Interfaces\ISubscriptionServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/** Class SubscriptionService */
class SubscriptionService implements ISubscriptionServiceInterface
{
    /**
     * @param ISubscriptionRepositoryInterface $subscriptionRepository
     * @param IUserRepositoryInterface         $userRepository
     */
    public function __construct(
        private readonly ISubscriptionRepositoryInterface $subscriptionRepository,
        private readonly IUserRepositoryInterface         $userRepository,
    ) {}

    /**
     * @param int $userId
     * @param int $subscribedToId
     * @return bool|string
     */
    public function checkSubscriptionStatus(int $userId, int $subscribedToId): bool | string
    {
        $subscription = $this->subscriptionRepository->findByUserIds($userId, $subscribedToId);

        if (!$subscription) {
            return false;
        }

        return $subscription->is_accepted ? true : 'requested';
    }

    /**
     * @param int $subscribedToId
     * @return void
     */
    public function toggleSubscription(int $subscribedToId): void
    {
        $currentUserId = Auth::id();
        $subscription  = $this->subscriptionRepository->findByUserIds($currentUserId, $subscribedToId);

        if ($subscription) {
            $this->subscriptionRepository->delete($subscription);
        } else {
            $targetUser = $this->userRepository->findById($subscribedToId);

            $isAccepted = $targetUser && $targetUser->is_private ? 0 : 1;

            $this->subscriptionRepository->create([
                'user_id'          => $currentUserId,
                'subscribed_to_id' => $subscribedToId,
                'is_accepted'      => $isAccepted,
            ]);
        }
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getFollowersData(int $userId): array
    {
        $requests  = $this->userRepository->getSubscriptionRequests();
        $followers = $this->subscriptionRepository->getFollowers($userId);

        return ['requests' => $requests, 'followers' => $followers];
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getSubscriptionsData(int $userId): Collection
    {
        $subscriptions = $this->subscriptionRepository->getSubscriptions($userId);

        $subscriptions->each(function ($user) use ($userId) {
            $user->subscription_status = $this->checkSubscriptionStatus($userId, $user->id);
        });

        return $subscriptions;
    }

    /**
     * @param int    $followerId
     * @param string $action
     * @return void
     */
    public function manageFollowerRequest(int $followerId, string $action): void
    {
        $subscription = $this->subscriptionRepository->findByUserIds($followerId, Auth::id());

        if ($subscription) {
            if ($action === 'accept') {
                $this->subscriptionRepository->accept($subscription);
            } elseif ($action === 'decline') {
                $this->subscriptionRepository->delete($subscription);
            }
        }
    }
}