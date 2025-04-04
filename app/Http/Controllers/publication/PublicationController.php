<?php

namespace App\Http\Controllers\publication;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
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
    public function publications(): View
    {
        $publications = Publication::where('user_id', '!=', auth()->user()->id)->get();
        foreach ($publications as $publication) {
            $publication->is_liked = UserPublicationLike::where('user_id', auth()->user()->id)
                ->where('publication_id', $publication->id)
                ->exists();
            $publication->is_reposted = UserPublicationRepost::where('user_id', auth()->user()->id)
                ->where('publication_id', $publication->id)
                ->exists();
            $publication->commentsCount = PublicationComment::where('publication_id', $publication->id)->count();
            $publication->comments = PublicationComment::where('publication_id', $publication->id)
                ->orderBy('updated_at', 'desc')->get();
            foreach ($publication->comments as $comment) {
                $comment->nickname = User::where('id', $comment->user_id)->value('nickname');
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

        // Ensure user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to like a publication.'
            ], 401);
        }

        $user_id = auth()->user()->id;
        $publication_id = $request->input('publication_id');

        DB::beginTransaction();
        try {
            // Check if the user has already liked the publication
            $existingLike = UserPublicationLike::where('user_id', $user_id)
                ->where('publication_id', $publication_id)
                ->first();

            $publication = Publication::findOrFail($publication_id);

            if ($existingLike) {
                // Unlike the publication
                $existingLike->delete();
                $publication->decrement('likes');
                $isLiked = false;
            } else {
                // Like the publication
                UserPublicationLike::create([
                    'user_id' => $user_id,
                    'publication_id' => $publication_id
                ]);
                $publication->increment('likes');
                $isLiked = true;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'liked' => $isLiked,
                'likes_count' => $publication->likes
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the actual error for debugging
            Log::error('Like Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage() // Only in development
            ], 500);
        }
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

        // Ensure user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to like a publication.'
            ], 401);
        }


        $publication_id = $request->input('publication_id');

        DB::beginTransaction();
        try {
            // Check if the user has already liked the publication
            $existingRepost = UserPublicationRepost::where('user_id', auth()->user()->id)
                ->where('publication_id', $publication_id)
                ->first();

            $publication = Publication::findOrFail($publication_id);

            if ($existingRepost) {
                // Unlike the publication
                $existingRepost->delete();
                $publication->decrement('reposts');
                $isReposted = false;
            } else {
                // Like the publication
                UserPublicationRepost::create([
                    'user_id' => auth()->user()->id,
                    'publication_id' => $publication_id
                ]);
                $publication->increment('reposts');
                $isReposted = true;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'reposted' => $isReposted,
                'reposts_count' => $publication->reposts
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the actual error for debugging
            Log::error('Repost Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage() // Only in development
            ], 500);
        }
    }

    /**
     * Method for commenting a publication.
     */

    public function storeComment(Request $request)
    {
        $data = [
            'publication_id' => $request->input('publication_id'),
            'user_id' => auth()->user()->id,
            'comment' => $request->input('comment')
        ];

        PublicationComment::create($data);

        return back();
    }
}
