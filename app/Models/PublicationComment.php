<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Class PublicationComment */
class PublicationComment extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'publication_comments';
    /** @var string[] */
    protected $fillable = [
        'publication_id',
        'user_id',
        'comment',
        'likes',
    ];

    /** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasMany|PublicationComment */
    public function likes(): HasMany | PublicationComment
    {
        return $this->hasMany(UserCommentLike::class, 'comment_id');
    }

    /** @return BelongsTo */
    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class);
    }

    public function author(): string
    {
        return $this->user->nickname ?? $this->user->name;
    }


    /** @return bool */
    public function isLiked(): bool
    {
        return $this->likes()->where('user_id', auth()->user()->id)->exists();
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
}
