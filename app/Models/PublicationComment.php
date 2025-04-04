<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicationComment extends Model
{
    protected $table = 'publications_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'publication_id',
        'user_id',
        'comment',
        'likes',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
