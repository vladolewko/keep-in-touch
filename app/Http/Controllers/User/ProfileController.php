<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserCommentLike;
use App\Models\UserNotification;
use App\Models\UserPublicationLike;
use App\Models\UserPublicationRepost;
use App\Models\UserSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function profile(): View
    {
        $user = auth()->user();

        $publications = User::getPublications($user);

        $reposts = User::getReposts($user);

        return view('profile/profile', compact('user', 'publications', 'reposts'));
    }

    /**
     * Display the user's followers page.
     */
    public function followers(): View
    {

        $requests = User::getRequests();

        $followersIds = UserSubscription::where('subscribed_to_id', auth()->user()->id)->where('is_accepted', 1)->pluck('user_id');
        $followers = User::whereIn('id', $followersIds)->get();
        return view('profile/followers', compact('requests', 'followers'));
    }

    /**
     * manage subscribitors
     */
    public function manageSubscribitors(Request $request)
    {
        $subscriber_id = $request->input('subscriber_id');
        $action = $request->input('action');
        UserSubscription::manageSubscribitors($subscriber_id, $action);

        return back();
    }


    /**
     * Display the user's subscriptions page.
     */
    public function subscriptions(): View
    {
        $subscriptionsIds = UserSubscription::where('user_id', auth()->user()->id)->pluck('subscribed_to_id');
        $subscriptions = User::whereIn('id', $subscriptionsIds)->get();

        foreach ($subscriptions as $user) {
            $user->subscription_status = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user->id);
        }

        return view('profile/subscriptions', compact('subscriptions'));
    }

    /**
     * Display the user's profile settings page.
     */
    public function settings(): View
    {
        return view('profile/profileSettings');
    }

    public function notifications(): View
    {
        $notifications = UserNotification::where('sended_to_id', auth()->user()->id)->get();

        return view('profile/notifications', compact('notifications'));
    }

    public function readNotification($id)
    {
        UserNotification::where('id', $id)->update(['is_read' => 1]);
        return back();
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->has('remove_image')) {
            // Just remove the image, don't update other fields
            auth()->user()->clearMediaCollection('profile_images');
        } else {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
//        dd($request->validated('profile_image'));
            $request->user()->addMedia($request->validated('profile_image'))
                ->toMediaCollection('profile_images');

            $request->user()->save();
        }


        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Change access to account
     */
    public function changeAccess(Request $request)
    {
        User::where('id', auth()->user()->id)->update(['is_private' => $request->input('access')]);

        return back();
    }

    /**
     * Delete the user's account.
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
