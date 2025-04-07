<?php

namespace App\Http\Controllers\publication;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserCommentLike;
use App\Models\UserPublicationLike;
use App\Models\UserPublicationRepost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PublicationController extends Controller
{
    /**
     * Display publications list page.
     */
    public function publications(Request $request): View
    {
        $parameter = $request->get('parameter') ?? null;
        $filter = $request->get('filter') ?? null;
        $publications = Publication::sortPublication($parameter, $filter);

        foreach ($publications as $publication) {
            $publication->nickname = User::where('id', $publication->user_id)->value('nickname');
            $publication->is_liked = UserPublicationLike::where('user_id', auth()->user()->id)->where('publication_id', $publication->id)->exists();
            $publication->is_reposted = UserPublicationRepost::where('user_id', auth()->user()->id)->where('publication_id', $publication->id)->exists();
            $publication->commentsCount = PublicationComment::where('publication_id', $publication->id)->count();
            $publication->comments = PublicationComment::where('publication_id', $publication->id)->orderBy('updated_at', 'desc')->get();

            foreach ($publication->comments as $comment) {
                $comment->nickname = User::where('id', $comment->user_id)->value('nickname');
                $comment->is_liked = UserCommentLike::where('user_id', auth()->user()->id)->where('comment_id', $comment->id)->exists();
            }
        }

        return view('publications/publicationsList', compact('publications'));
    }

    /**
     * Display publications list page.
     */
    public function subscriptions(): View
    {
        return view('publications/subscriptionsPublications');
    }

    /**
     * Method for creating new publication.
     */
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        $data = [
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ];

        Publication::create($data);

        return back();
    }

    /**
     * Method for editing new publication.
     */
    public function edit($id)
    {
        $publication = Publication::findOrFail($id);
        return view('publications/edit', compact('publication'));
    }

    /**
     * Method for updating publication.
     */
    public function update(Request $request)
    {
        $publication_id = $request->input('publication_id');
        $data = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ];
        $request->validate([
            'publication_id' => 'required|exists:publications,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        if (!Publication::where('id', $publication_id)->update($data) || $data['title'] == null) {

            return back()->with('error', 'Publication not found or update failed.');
        }


        return redirect('profile/myProfile');
    }


    /**
     * Method for liking/unliking a publication.
     */
    public function like(Request $request)
    {
        // Validate the request
        $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ]);
        $publication_id = $request->input('publication_id');

        return UserPublicationLike::likePublication($publication_id);
    }

    /**
     * Method for repost/unrepost a publication.
     */
    public function repost(Request $request)
    {
        // Validate the request
        $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ]);
        $publication_id = $request->input('publication_id');

        return UserPublicationRepost::repostPublication($publication_id);
    }

    /**
     * Method for hiding/unhiding a publication.
     */
    public function hide(Request $request)
    {
        // Validate the request
        $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ]);
        $publication_id = $request->input('publication_id');

        Publication::hidePublication($publication_id);

        return back();
    }

}
