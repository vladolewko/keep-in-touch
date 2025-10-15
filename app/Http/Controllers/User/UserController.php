<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ISubscriptionServiceInterface;
use App\Services\Interfaces\IUserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly IUserServiceInterface $userService,
         private readonly ISubscriptionServiceInterface $subscriptionService
    ) {}

    public function users(Request $request): View
    {
        $users = $this->userService->getSortedUsers($request->all());

        return view('users/usersList', compact('users'));
    }

    public function profile($id): View
    {
        $user = $this->userService->findUserById($id);
        abort_if(!$user, 404);
        $haveAccess = $this->userService->hasAccessToProfile($id);
        $subscriptionStatus = $this->subscriptionService->checkSubscriptionStatus(auth()->id(), $id);
        $publications = $this->userService->getUserPublications($user);
        $reposts = $this->userService->getUserReposts($user);

        return view('users/userProfile', compact('user', 'publications', 'reposts', 'haveAccess', 'subscriptionStatus'));
    }

    public function changeSubscription(Request $request): RedirectResponse
    {
        $data = $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $this->subscriptionService->toggleSubscription($data['user_id']);

        return back();
    }
}