<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Interfaces\INotificationServiceInterface;
use App\Services\Interfaces\ISubscriptionServiceInterface;
use App\Services\Interfaces\IUserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/** Class ProfileController */
class ProfileController extends Controller
{
    /**
     * @param IUserServiceInterface         $userService
     * @param ISubscriptionServiceInterface $subscriptionService
     * @param INotificationServiceInterface $notificationService
     */
    public function __construct(
        private readonly IUserServiceInterface         $userService,
        private readonly ISubscriptionServiceInterface $subscriptionService,
        private readonly INotificationServiceInterface $notificationService,
    ) {}

    /** @return View */
    public function profile(): View
    {
        $user         = auth()->user();
        $publications = $this->userService->getUserPublications($user);
        $reposts      = $this->userService->getUserReposts($user);

        return view('profile.index', compact('user', 'publications', 'reposts'));
    }

    /** @return View */
    public function followers(): View
    {
        $data = $this->subscriptionService->getFollowersData(Auth::id());
        return view('profile/followers', $data);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function manageSubscribitors(Request $request): RedirectResponse
    {
        $this->subscriptionService->manageFollowerRequest(
            $request->input('subscriber_id'),
            $request->input('action'),
        );

        return back();
    }

    /**
     * @return View
     */
    public function subscriptions(): View
    {
        $subscriptions = $this->subscriptionService->getSubscriptionsData(Auth::id());
        return view('profile/subscriptions', compact('subscriptions'));
    }

    /**
     * @return View
     */
    public function notifications(): View
    {
        $notifications = $this->notificationService->get(Auth::id());
        return view('profile/notifications', compact('notifications'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function readNotification($id): RedirectResponse
    {
        $this->notificationService->markAsRead($id);
        return back();
    }

    /**
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->userService->updateProfile($request->user(), $request->validated());
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeAccess(Request $request): RedirectResponse
    {
        $this->userService->changeProfileAccess($request->input('access'));
        return back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}