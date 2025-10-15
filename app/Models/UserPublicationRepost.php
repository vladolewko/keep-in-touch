<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/** Class UserPublicationRepost */
class UserPublicationRepost extends Model
{
    /** @var string */
    protected $table      = 'user_publication_reposts';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'publication_id',
        'repost_comment'
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
