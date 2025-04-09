<?php

namespace App\Http\Controllers\user;

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

        $publications = Publication::where('user_id', $user->id)->get();
        foreach ($publications as $publication) {
            $publication->is_liked = UserPublicationLike::where('user_id', $user->id)->where('publication_id', $publication->id)->exists();
            $publication->is_reposted = UserPublicationRepost::where('user_id', $user->id)->where('publication_id', $publication->id)->exists();
            $publication->commentsCount = PublicationComment::where('publication_id', $publication->id)->count();

            $publication->comments = PublicationComment::where('publication_id', $publication->id)->orderBy('updated_at', 'desc')->get();
            foreach ($publication->comments as $comment) {
                $comment->nickname = User::where('id', $comment->user_id)->value('nickname');
                $comment->is_liked = UserCommentLike::where('user_id', auth()->user()->id)->where('comment_id', $comment->id)->exists();
            }
        }

        $repostsId = UserPublicationRepost::where('user_id', $user->id)->pluck('publication_id');
        $reposts = Publication::whereIn('id', $repostsId)->get();
        foreach ($reposts as $repost) {
            $repost->is_liked = UserPublicationLike::where('user_id', $user->id)->where('publication_id', $repost->id)->exists();
            $repost->is_reposted = UserPublicationRepost::where('user_id', auth()->user()->id)->where('publication_id', $repost->id)->exists();
        }

        return view('users/userProfile', compact('user', 'publications', 'reposts'));
    }



    /**
     * method for subscribing/unsubscribing to a user.
     */
    public function changeSubscription(Request $request)
    {
        $user_id = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        UserSubscription::changeSubscription($user_id);

        return back();
    }

}
