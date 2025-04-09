<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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


    public static function likeComment($publication_id)
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
            $existingLike = PublicationLi::where('user_id', $user_id)
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
}
