<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Models\PublicationComment;
use App\Models\UserCommentLike;
use Illuminate\Http\Request;

class PublicationCommentController extends Controller
{
    public function like(Request $request)
    {
        // Validate the request
        $comment_id = $request->validate([
            'comment_id' => 'required|exists:publication_comments,id'
        ])['comment_id'];


        return UserCommentLike::likePublication($comment_id);
    }

    /**
     * Method for commenting a publication.
     */
    public function storeComment(Request $request)
    {
        $data =$request->validate([
            'publication_id' => 'required|exists:publications,id',
            'comment' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->user()->id;

        PublicationComment::create($data);

        return back();
    }
}
