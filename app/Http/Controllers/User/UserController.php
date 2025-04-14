<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserCommentLike;
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
    public function users(Request $request): View
    {
        $parameter = $request->get('parameter') ?? null;
        $search = $request->get('search') ?? null;

        $users = User::sortUsers($parameter, $search);

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

        $publications = User::getPublications($user);

        $reposts = User::getReposts($user);

        return view('users/userProfile', compact('user', 'publications', 'reposts'));
    }



    /**
     * method for subscribing/unsubscribing to a user.
     */
    public function changeSubscription(Request $request)
    {
        $user_id = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ])['user_id'];

        UserSubscription::changeSubscription($user_id);

        return back();
    }

}
