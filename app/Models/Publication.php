<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publication extends Model
{
    use SoftDeletes;

    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory;

    protected $table = 'publications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'description',
        'likes',
        'reposts',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function hidePublication($publication_id)
    {
        $publication = Publication::withTrashed()->find($publication_id);

        if ($publication->trashed()) {

            $publication->restore();

        } else {
            $publication->delete();
        }
    }

    public static function sortPublication($parameter = null, $filter = null)
    {
        $query = Publication::query();

        // Assuming publications have a user_id field to identify who created them
        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->user()->id);
        }
        if ($filter === 'subscriptions') {
            $subscriptions = UserSubscription::where('user_id', auth()->user()->id)
                ->pluck('subscribed_to_id');

            $query->whereIn('user_id', $subscriptions);
        }

        if ($parameter === 'likes ASC') {
            $query->orderBy('likes', 'asc');
        } elseif ($parameter === 'likes DESC') {
            $query->orderBy('likes', 'desc');
        } elseif ($parameter === 'reposts ASC') {
            $query->orderBy('reposts', 'asc');
        } elseif ($parameter === 'reposts DESC') {
            $query->orderBy('reposts', 'desc');
        } elseif ($parameter === 'newest') {
            $query->orderBy('updated_at', 'desc'); // Most recent first
        } elseif ($parameter === 'oldest') {
            $query->orderBy('updated_at', 'asc');  // Oldest first
        }

        return $query->get();
    }
}
