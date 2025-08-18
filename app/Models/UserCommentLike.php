<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserCommentLike extends Model
{
    protected $table = 'user_comment_likes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'comment_id',
        ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(PublicationComment::class, 'comment_id');
    }


    /**
     * method for liking or unliking a publication
     *
     * @param $comment_id
     *
     * @return JsonResponse
     */
    public static function likePublication($comment_id): JsonResponse
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to like a publication.'
            ], 401);
        }

        $user_id = auth()->user()->id;

        DB::beginTransaction();
        try {
            $existingLike = UserCommentLike::where('user_id', $user_id)
                ->where('comment_id', $comment_id)
                ->first();

            $publicationComment = PublicationComment::findOrFail($comment_id);

            if ($existingLike) {

                $existingLike->delete();
                $publicationComment->decrement('likes');
                $isLiked = false;
            } else {

                // Like the publication
                UserCommentLike::create([
                    'user_id' => $user_id,
                    'comment_id' => $comment_id
                ]);
                $publicationComment->increment('likes');
                $isLiked = true;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'liked' => $isLiked,
                'likes_count' => $publicationComment->likes
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
}
