<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPublicationLike extends Model
{
    use HasFactory;
    protected $table = 'user_publication_likes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'publication_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class);
    }
}