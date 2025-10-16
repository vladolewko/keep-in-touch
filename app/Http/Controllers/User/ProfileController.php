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

class ProfileController extends Controller
{
    public function __construct(
        private readonly IUserServiceInterface $userService,
        private readonly ISubscriptionServiceInterface $subscriptionService,
        private readonly INotificationServiceInterface $notificationService
    ) {}

    public function profile(): View
    {
        $user = auth()->user();
        $publications = $this->userService->getUserPublications($user);
        $reposts = $this->userService->getUserReposts($user);

        return view('profile/profile', compact('user', 'publications', 'reposts'));
    }
    public function followers(): View
    {
        $data = $this->subscriptionService->getFollowersData(Auth::id());
        return view('profile/followers', $data);
    }

    public function manageSubscribitors(Request $request): RedirectResponse
    {
        $this->subscriptionService->manageFollowerRequest(
            $request->input('subscriber_id'),
            $request->input('action')
        );

        return back();
    }

    public function subscriptions(): View
    {
        $subscriptions = $this->subscriptionService->getSubscriptionsData(Auth::id());
        return view('profile/subscriptions', compact('subscriptions'));
    }

    public function notifications(): View
    {
        $notifications = $this->notificationService->get(Auth::id());
        return view('profile/notifications', compact('notifications'));
    }

    public function readNotification($id): RedirectResponse
    {
        $this->notificationService->markAsRead($id);
        return back();
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->userService->updateProfile($request->user(), $request->validated());
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function changeAccess(Request $request): RedirectResponse
    {
        $this->userService->changeProfileAccess($request->input('access'));
        return back();
    }

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