<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publication extends Model
{
    use SoftDeletes;
    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory;
    protected $table = 'publications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'description',
        'likes',
        'reposts',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function hidePublication($publication_id)
    {
        $publication = Publication::withTrashed()->find($publication_id);

        if ($publication->trashed()) {

            Publication::where('id', $publication_id)->restore();

        } else {
            Publication::where('id', $publication_id)->delete();
        }
    }
}
