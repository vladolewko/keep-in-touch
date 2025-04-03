<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\User;
use App\Models\UserPublicationLike;
use App\Models\UserPublicationRepost;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the users list page.
     */
    public function users(): View
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        foreach ($users as $user) {
            $user->subscription_status = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user->id);

        }
        return view('users/usersList', compact('users'));
    }

    /**
     * Display the users list page.
     */
    public function profile($id): View
    {
        $user = User::find($id);
        $user->haveAccess = User::checkIfHaveAccess($user->id);
        $user->subscription_status = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user->id);

        $publications = Publication::where('user_id', $user->id)->get();
        foreach ($publications as $publication) {
            $publication->is_liked = UserPublicationLike::where('user_id', $user->id)->where('publication_id', $publication->id)->exists();
            $publication->is_reposted = UserPublicationRepost::where('user_id', $user->id)
                ->where('publication_id', $publication->id)
                ->exists();
        }

        $repostsId = UserPublicationRepost::where('user_id', $user->id)->pluck('publication_id');
        $reposts = Publication::whereIn('id', $repostsId)->get();
        foreach ($reposts as $repost) {
            $repost->is_liked = UserPublicationLike::where('user_id', $user->id)->where('publication_id', $repost->id)->exists();
            $repost->is_reposted = UserPublicationRepost::where('user_id', auth()->user()->id)
                ->where('publication_id', $repost->id)
                ->exists();
        }

        return view('users/userProfile', compact('user', 'publications', 'reposts'));
    }



    /**
     * method for subscribing/unsubscribing to a user.
     */
    public function changeSubscription(Request $request)
    {
        $user_id = auth()->user()->id;
        $subscribe_to_id = $request->input('user_id');

        UserSubscription::changeSubscription($user_id, $subscribe_to_id);

        return back();
    }




}
