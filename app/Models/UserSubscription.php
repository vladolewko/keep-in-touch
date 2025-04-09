<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use SoftDeletes;
    protected $table = 'user_subscriptions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'subscribed_to_id',
        'is_accepted'
    ];


    /**
     * method for checking status of subscription to another user
     */
    public static function checkSubscriptionStatus($userId, $subscribedToId)
    {
        $subscription = UserSubscription::where('user_id', $userId)
            ->where('subscribed_to_id', $subscribedToId)
            ->first();
        if ($subscription) {
            if ($subscription->is_accepted == 1) {
                return true;
            } elseif ($subscription->is_accepted == 0) {
                return 'requested';
            }
        } else {
            return false;
        }
    }


    /**
     * method for subscribing or unsubscribing to another user
     */
    public static function changeSubscription($subscribed_to_id)
    {
        $user_id = auth()->user()->id;
        $userAccess = User::where('id', $subscribed_to_id)->value('is_private');
        $subscription = self::checkSubscriptionStatus($user_id, $subscribed_to_id);

        if ($subscription) {
            UserSubscription::where('user_id', $user_id)
                ->where('subscribed_to_id', $subscribed_to_id)
                ->delete();
        } else {
            UserSubscription::create([
                'user_id' => $user_id,
                'subscribed_to_id' => $subscribed_to_id,
                'is_accepted' => $userAccess == 1 ? 0 : 1
            ]);
        }
    }


    /**
     * method for subscribing/unsubscribing followers
     */
    public static function manageSubscribitors($user_id, $action)
    {
        if ($action == 'decline') {
            UserSubscription::where('user_id', $user_id)
                ->where('subscribed_to_id', auth()->user()->id)
                ->delete();

        } elseif ($action == 'accept') {
            UserSubscription::where('user_id', $user_id)
                ->where('subscribed_to_id', auth()->user()->id)
                ->update(['is_accepted' => 1]);
        }
    }
}
