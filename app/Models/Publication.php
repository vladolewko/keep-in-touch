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
        return $this->hasMany(UserPublicationLike::class);
    }

    /** @return HasMany */
    public function reposts(): HasMany
    {
        return $this->hasMany(UserPublicationRepost::class);
    }

    /** @return HasMany */
    public function comments(): HasMany
    {
        return $this->hasMany(PublicationComment::class);
    }

    /** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /** @return BelongsTo */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->nickname;
    }

}
