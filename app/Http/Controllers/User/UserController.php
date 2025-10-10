<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function users(Request $request): View
    {
        $parameter = $request->get('parameter');
        $search = $request->get('search');

        $users = User::sortUsers($parameter, $search);

        foreach ($users as $user) {
            $user->subscription_status = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user->id);

        }

        return view('users/usersList', compact('users'));
    }

    public function profile($id): View
    {
        $user = User::find($id);

        $user->haveAccess = User::checkIfHaveAccess($user->id);
        $user->subscription_status = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user->id);

        $publications = User::getPublications($user);

        $reposts = User::getReposts($user);

        return view('users/userProfile', compact('user', 'publications', 'reposts'));
    }

    public function changeSubscription(Request $request): RedirectResponse
    {
        $user_id = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ])['user_id'];

        UserSubscription::changeSubscription($user_id);

        return back();
    }

}
