<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Publication extends Model implements HasMedia
{

    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

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

    // Relations
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


    // Users Methods

    /**
     * method for getting list of publications
     *
     * @param $parameter
     * @param $filter
     * @param $search
     *
     * @return array
     */
    public static function getPublicationsList($parameter, $filter, $search): array
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

    /**
     * method for toggle publication status
     *
     * @param $publication_id
     *
     * @return void
     */
    public static function togglePublication($publication_id): void
    {
        $publication = Publication::withTrashed()->find($publication_id);

        if ($publication->trashed()) {

            $publication->restore();

        } else {
            $publication->delete();
        }
    }

    /**
     * method for delete publication
     *
     * @param $publication_id
     *
     * @return void
     */
    public static function destroy($publication_id): void
    {
        $publication = Publication::withTrashed()->findOrFail($publication_id);
        $publication->clearMediaCollection();
        $publication->forceDelete();
    }


    /**
     * method for sorting list of publications
     *
     * @param $parameter
     * @param $filter
     * @param $search
     *
     * @return array
     */
    public static function sortPublication($parameter = null, $filter = null, $search = null): array
    {
        $query = Publication::query();
        $query->with('user');

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
        } elseif ($parameter === 'id ASC') {
            $query->orderBy('id', 'asc');
        } elseif ($parameter === 'id DESC') {
            $query->orderBy('id', 'desc');
        }else {
            $query->orderBy('updated_at', 'desc');
        }
        return $query->paginate(10);
    }


    // Admin Methods


    /**
     * method for getting list of publications
     *
     * @param $parameter
     * @param $filter
     * @param $search
     *
     * @return array
     */
    public static function AdminGetPublications($parameter, $filter, $search)
    {

        $publications = Publication::sortPublication($parameter, $filter, $search);

        foreach ($publications as $publication) {
            $publication->nickname = User::withTrashed()->where('id', $publication->user_id)->value('nickname');
        }
        return $publications;
    }

}
