<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;
    use softDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'surname',
        'nickname',
        'email',
        'phone',
        'bio',
        'address',
        'is_private',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    public function publicationLikes(): HasMany
    {
        return $this->hasMany(UserPublicationLike::class);
    }

    public function commentLikes(): HasMany
    {
        return $this->hasMany(UserCommentLike::class);
    }

    public function publicationReposts(): HasMany
    {
        return $this->hasMany(UserPublicationRepost::class);
    }

    public function comments(): HasMany|null
    {
        return $this->hasMany(PublicationComment::class);
    }

    public static function getReposts($user)
    {

        $reposts_id = UserPublicationRepost::where('user_id', $user->id)->pluck('publication_id');

        $reposts = Publication::whereIn('id', $reposts_id)
            ->withCount([
                'likes as has_likes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'reposts as has_reposts' => function ($query) {
                    $query->where('user_id', auth()->user()->id);
                },
            ])
            ->get();

        foreach ($reposts as $repost) {
            $repost->is_liked = $repost->likes()->where('user_id', auth()->user()->id)->where('publication_id', $repost->id)->exists();
            $repost->is_reposted = $repost->reposts()->where('user_id', auth()->user()->id)->where('publication_id', $repost->id)->exists();
        }
        return $reposts;
    }

    public static function getRequests()
    {
        $user_id = auth()->user()->id;

        $requests_id = UserSubscription::where('subscribed_to_id', $user_id)->where('is_accepted', 0)->pluck('user_id');

        return self::whereIn('id', $requests_id)->get();

    }

    public static function getPublications($user): Collection
    {
        $publications = Publication::withTrashed()
            ->where('user_id', $user->id)
            ->with(['comments' => function ($query) {
                $query->orderBy('updated_at', 'desc')->with('user:id,nickname');
            }])
            ->get();

        foreach ($publications as $publication) {
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
     * method for getting list of users
     *
     * @param $parameter
     * @param $search
     * @param $filter
     *
     * @return LengthAwarePaginator
     */
    public static function sortUsers($parameter = null, $search = null, $filter = null): LengthAwarePaginator
    {
        $query = self::query();

        if (auth()->check()) {
            $query->where('id', '!=', auth()->user()->id)
                ->where('role', '!=', 'admin');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }
        switch ($parameter) {
            case 'newest':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('updated_at', 'asc');
                break;
            case 'nickname ASC':
                $query->orderBy('nickname', 'asc');
                break;
            case 'nickname DESC':
                $query->orderBy('nickname', 'desc');
                break;
            case 'name ASC':
                $query->orderBy('name', 'asc');
                break;
            case 'name DESC':
                $query->orderBy('name', 'desc');
                break;
            case 'id ASC':
                $query->orderBy('id', 'asc');
                break;
            case 'id DESC':
                $query->orderBy('id', 'desc');
                break;
            default:
                $query->orderBy('updated_at', 'asc');
        }

        return $query->paginate(10);
    }

    public static function adminSortUsers($parameter = null, $search = null, $filter = null): LengthAwarePaginator
    {
        if ($filter === 'blocked') {
            $query = self::onlyTrashed();
        } elseif ($filter === 'unblocked') {
            $query = self::where('role', '!=', 'admin');
        } else {
            $query = self::withTrashed();
        }

        if (auth()->check()) {
            $query->where('id', '!=', auth()->user()->id)
                ->where('role', '!=', 'admin');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        switch ($parameter) {
            case 'newest':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('updated_at', 'asc');
                break;
            case 'nickname ASC':
                $query->orderBy('nickname', 'asc');
                break;
            case 'nickname DESC':
                $query->orderBy('nickname', 'desc');
                break;
            case 'name ASC':
                $query->orderBy('name', 'asc');
                break;
            case 'name DESC':
                $query->orderBy('name', 'desc');
                break;
            case 'id ASC':
                $query->orderBy('id', 'asc');
                break;
            case 'id DESC':
                $query->orderBy('id', 'desc');
                break;
            default:
                $query->orderBy('updated_at', 'asc');
        }

        return $query->paginate(10);
    }

    public static function changeAccess($access): bool
    {
        if ($access === 'private') {
            $access = 1;
        } else {
            $access = 0;
        }

        return self::where('id', auth()->user()->id)->update(['is_private' => $access]);

    }

    public static function checkIfHaveAccess($user_id): bool
    {
        $user = self::find($user_id);
        $subscription = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user_id);
        if ($user->is_private == 1) {
            return $subscription === true;
        }
        return true;
    }

    public static function blockUser($user_id): bool
    {
        $user = self::find($user_id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
