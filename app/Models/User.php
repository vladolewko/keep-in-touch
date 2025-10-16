<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/** Class User */
class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia, SoftDeletes;

    /** @var string */
    protected $table = 'users';
    /** @var string[] */
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
    /** @var string[] */
    protected $hidden = ['password', 'remember_token'];

    /** @return string[] */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** @return HasMany */
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    /** @return HasMany */
    public function publicationLikes(): HasMany
    {
        return $this->hasMany(UserPublicationLike::class);
    }

    /** @return HasMany */
    public function commentLikes(): HasMany
    {
        return $this->hasMany(UserCommentLike::class);
    }

    /** @return HasMany */
    public function publicationReposts(): HasMany
    {
        return $this->hasMany(UserPublicationRepost::class);
    }

    /** @return HasMany */
    public function comments(): HasMany
    {
        return $this->hasMany(PublicationComment::class);
    }
}