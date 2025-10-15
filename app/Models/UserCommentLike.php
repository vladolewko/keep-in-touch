<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Class UserCommentLike */
class UserCommentLike extends Model
{
    /** @var string*/
    protected $table    = 'user_comment_likes';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'comment_id',
    ];

    /** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(PublicationComment::class, 'comment_id');
    }
}
