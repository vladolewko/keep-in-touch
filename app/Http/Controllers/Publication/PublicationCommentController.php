<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Models\PublicationComment;
use App\Models\UserCommentLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicationCommentController extends Controller
{
    public function like(Request $request): JsonResponse
    {
        // Validate the request
        $comment_id = $request->validate([
            'comment_id' => 'required|exists:publication_comments,id'
        ])['comment_id'];


        return UserCommentLike::likePublication($comment_id);
    }

    public function storeComment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'publication_id' => 'required|exists:publications,id',
            'comment' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->user()->id;

        PublicationComment::create($data);

        return back();
    }
}
