<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserPublicationRepost extends Model
{
    protected $table = 'user_publication_reposts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'publication_id',
        'repost_comment'
    ];


    /**
     * method for reposting or unreposting a publication
     */
    public static function repostPublication($publication_id)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to like a publication.'
            ], 401);
        }

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
}
