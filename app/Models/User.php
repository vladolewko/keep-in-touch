<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User.php
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

    public function comments(): HasMany
    {
        return $this->hasMany(PublicationComment::class);
    }


    public static function getReposts($user)
    {

        $reposts_id = UserPublicationRepost::where('user_id', $user->id)->pluck('publication_id');

        $reposts = Publication::whereIn('id', $reposts_id)
            ->withCount([
                'likes as has_likes' => function($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'reposts as has_reposts' => function($query) {
                    $query->where('user_id', auth()->user()->id);
                }
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

        $requests = User::whereIn('id', $requests_id)->get();

        return $requests;
    }


    public static function getPublications($user)
    {
        $publications = Publication::withTrashed()
            ->where('user_id', $user->id)
            ->with(['comments' => function($query) {
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


    public static function sortUsers($parameter = null, $search = null)
    {
        $query = User::query();

        if (auth()->check()) {
            $query->where('id', '!=', auth()->user()->id)->where('role', '!=', 'admin')->orderBy('updated_at', 'asc');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        if ($parameter === 'newest') {
            $query->orderBy('updated_at', 'desc');
        } elseif ($parameter === 'oldest') {
            $query->orderBy('updated_at', 'asc');
        } elseif ($parameter === 'nickname ASC') {
            $query->orderBy('nickname', 'asc');
        } elseif ($parameter === 'nickname DESC') {
            $query->orderBy('nickname', 'desc');
        } elseif ($parameter === 'name ASC') {
            $query->orderBy('name', 'asc');
        } elseif ($parameter === 'name DESC') {
            $query->orderBy('name', 'desc');
        } elseif ($parameter === 'id ASC') {
            $query->orderBy('id', 'asc');
        } elseif ($parameter === 'id DESC') {
            $query->orderBy('id', 'desc');
        }

        return $query->get();
    }


    /**
     * method for making account private or public
     */
    public static function changeAccess($access)
    {
        if ($access == 'private') {
            $access = 1;
        } else {
            $access = 0;
        }

      return User::where('id', auth()->user()->id)->update(['is_private' => $access]);

    }

    /**
     * method for checking if user has access to account
     */
    public static function checkIfHaveAccess($user_id)
    {
       $user = User::find($user_id);
       $subscription = UserSubscription::checkSubscriptionStatus(auth()->user()->id, $user_id);
        if ($user->is_private == 1) {
            if ($subscription === true) {
                return true;

            } else {
                return false;
            }

        } else {
                return true;
        }

    }
}
