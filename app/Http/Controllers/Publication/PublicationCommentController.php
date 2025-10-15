<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICommentServiceInterface;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicationCommentController extends Controller
{
    public function __construct(private readonly ICommentServiceInterface $commentService) {}

    public function toggleLike(Request $request): JsonResponse
    {
        $data = $request->validate(['comment_id' => 'required|exists:publication_comments,id']);

        try {
            $result = $this->commentService->toggleLike($data['comment_id'], Auth::id());

            return response()->json(['success' => true] + $result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
            ], 500);
        }
    }

    public function storeComment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'publication_id' => 'required|exists:publications,id',
            'comment'        => 'required|string|max:255',
        ]);

        $this->commentService->createComment($data, Auth::id());

        return back()->with('success', 'Comment added successfully.');
    }
}
