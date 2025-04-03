<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'communities';
    protected $primaryKey = 'id';
    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'is_private',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
