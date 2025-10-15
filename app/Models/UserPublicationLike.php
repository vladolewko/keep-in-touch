<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Class UserPublicationLike */
class UserPublicationLike extends Model
{
    use HasFactory;

    /** @var string */
    protected $table      = 'user_publication_likes';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'publication_id'
    ];

    /** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo */
    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class);
    }
}