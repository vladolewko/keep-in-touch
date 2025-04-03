<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPublicationRepost extends Model
{
    protected $table = 'users_publications_reposts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'publication_id',
        'repost_comment',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
