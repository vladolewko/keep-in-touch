<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ISubscriptionServiceInterface;
use App\Services\Interfaces\IUserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Class UserController */
class UserController extends Controller
{
    /**
     * @param IUserServiceInterface         $userService
     * @param ISubscriptionServiceInterface $subscriptionService
     */
    public function __construct(
        private readonly IUserServiceInterface         $userService,
        private readonly ISubscriptionServiceInterface $subscriptionService,
    ) {}

    /**
     * @param Request $request
     * @return View
     */
    public function users(Request $request): View
    {
        $users = $this->userService->getSortedUsers($request->all());

        return view('users/index', compact('users'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function profile(int $id): View
    {
        $user = $this->userService->findUserById($id);
        abort_if(!$user, 404);
        $haveAccess         = $this->userService->hasAccessToProfile($id);
        $subscriptionStatus = $this->subscriptionService->checkSubscriptionStatus(auth()->id(), $id);
        $publications       = $this->userService->getUserPublications($user);
        $reposts            = $this->userService->getUserReposts($user);

        return view('users.user', compact('user', 'publications', 'reposts', 'haveAccess', 'subscriptionStatus'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeSubscription(Request $request): RedirectResponse
    {
        $data = $request->validate(['user_id' => 'required|integer|exists:users,id']);
        $this->subscriptionService->toggleSubscription($data['user_id']);

        return back();
    }
}