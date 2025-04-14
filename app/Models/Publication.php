<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publication extends Model
{

    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory,SoftDeletes;

    protected $table = 'publications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'description',
        'likes',
        'reposts'
    ];

    // Publication.php
    public function likes() {
        return $this->hasMany(UserPublicationLike::class);
    }

    public function reposts() {
        return $this->hasMany(UserPublicationRepost::class);
    }

    public function comments() {
        return $this->hasMany(PublicationComment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function getPublicationsList($parameter, $filter, $search)
    {
        $publications = Publication::sortPublication($parameter, $filter, $search);

        foreach ($publications as $publication) {
            $publication->nickname = $publication->user->nickname;
            $publication->is_liked = $publication->likes()->where('user_id', auth()->user()->id)->where('publication_id', $publication->id)->exists();
            $publication->is_reposted = $publication->reposts()->where('user_id', auth()->user()->id)->where('publication_id', $publication->id)->exists();
            $publication->commentsCount = $publication->comments->count();

            foreach ($publication->comments as $comment) {
                $comment->nickname = $comment->user->nickname;
                $comment->is_liked = $comment->likes()->where('user_id', auth()->user()->id)->exists();
            }
        }
        return $publications;
    }


    public static function togglePublication($publication_id)
    {
        $publication = Publication::withTrashed()->find($publication_id);

        if ($publication->trashed()) {

            $publication->restore();

        } else {
            $publication->delete();
        }
    }
//
//    public static function destroy($publication_id)
//    {
//        $publication = Publication::withTrashed()->findOrFail($publication_id);
//
//        $publication->forceDelete();
//    }


    public static function sortPublication($parameter = null, $filter = null, $search = null)
    {
        $query = Publication::query();

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->user()->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
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
            $query->orderBy('updated_at', 'desc');
        } elseif ($parameter === 'oldest') {
            $query->orderBy('updated_at', 'asc');
        }

        return $query->get();
    }
}
