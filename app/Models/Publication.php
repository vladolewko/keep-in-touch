<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class    Publication extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $table = 'publications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'description',
        'likes',
        'reposts',
    ];

    // Relations
    public function likes()
    {
        return $this->hasMany(UserPublicationLike::class);
    }

    public function reposts()
    {
        return $this->hasMany(UserPublicationRepost::class);
    }

    public function comments()
    {
        return $this->hasMany(PublicationComment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
    public function author():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->nickname;
    }

}
