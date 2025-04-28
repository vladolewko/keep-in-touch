<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublicationComment extends Model
{
    protected $table = 'publication_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'publication_id',
        'user_id',
        'comment',
        'likes',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(UserCommentLike::class, 'comment_id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }


    /**
     * method for liking/unliking a comment
     *
     * @param $publication_id
     *
     * @return JsonResponse
     */
    public static function likeComment($publication_id): JsonResponse
    {
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
                ->where('publication_id', $publication_id)
                ->first();

            $publication = Publication::findOrFail($publication_id);

            if ($existingLike) {

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


    // Admin methods

    /**
     * method for getting comments for admin
     *
     * @param $parameter
     * @param $search
     *
     * @return array
     */
    public static function AdminGetComments($parameter, $search): array
    {
        $query = PublicationComment::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('nickname', 'like', "%{$search}%");
                    });
            });
        }

        if ($parameter === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($parameter === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($parameter === 'id ASC') {
            $query->orderBy('id', 'asc');
        } elseif ($parameter === 'id DESC') {
            $query->orderBy('id', 'desc');
        } elseif ($parameter === 'nickname ASC') {

            $query->join('users', 'publication_comments.user_id', '=', 'users.id')
                ->orderBy('users.nickname', 'asc')
                ->select('publication_comments.*');
        } elseif ($parameter === 'nickname DESC') {

            $query->join('users', 'publication_comments.user_id', '=', 'users.id')
                ->orderBy('users.nickname', 'desc')
                ->select('publication_comments.*');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $comments = $query->paginate(10);

        foreach ($comments as $comment) {
            $comment->nickname = User::where('id', $comment->user_id)->value('nickname');
        }

        return $comments;
    }
}
