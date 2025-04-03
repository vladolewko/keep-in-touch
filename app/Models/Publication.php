<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
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

//    public static function create($data)
//    {
//        Publication::create($data);
//    }
}
