<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/** Class Publication */
class Publication extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    /** @var string */
    protected $table = 'publications';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'description',
        'likes',
        'reposts',
    ];

    /** @return HasMany */
    public function likes(): HasMany
    {
        return $this->hasMany(UserPublicationLike::class, 'publication_id');
    }

    /** @return HasMany */
    public function reposts(): HasMany
    {
        return $this->hasMany(UserPublicationRepost::class, 'publication_id');
    }

    /** @return HasMany */
    public function comments(): HasMany
    {
        return $this->hasMany(PublicationComment::class, 'publication_id');
    }

    /** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /** @return string|null */
    public function author(): ?string
    {
        return $this->user->nickname ?? $this->user->name;
    }

    /** @return bool */
    public function isLiked(): bool
    {
        return $this->likes()->where('user_id', auth()->user()->id)->exists();
    }
    /** @return bool */
    public function isReposted(): bool
    {
        return $this->reposts()->where('user_id', auth()->user()->id)->exists();
    }

    public function isOwn(): bool
    {
        return $this->user_id === auth()->user()->id;
    }

    public function countLikes(): int
    {
        return $this->likes()->count();
    }

    public function countReposts(): int
    {
        return $this->reposts()->count();
    }

    public function countComments(): int
    {
        return $this->comments()->count();
    }
}
