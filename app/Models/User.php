<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
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


    public static function sortUsers($parameter = null, $search = null)
    {
        $query = User::query();

        if (auth()->check()) {
            $query->where('id', '!=', auth()->user()->id)->orderBy('updated_at', 'asc');
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
