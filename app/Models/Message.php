<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Class Message
 * @property mixed $conversation_id
 */
class Message extends Model
{
    use HasFactory;
    /** @var array */
    protected $guarded = [];
    /** @var string[] */
    protected $touches = ['conversation'];

    /** @return BelongsTo */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
