<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPublicationLike extends Model
{
    protected $table = 'users_publications_likes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'publication_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
