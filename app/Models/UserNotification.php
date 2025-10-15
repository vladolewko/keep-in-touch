<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNotification extends Model
{
    use SoftDeletes,
        HasFactory;
    protected $table = 'user_notifications';
    protected $fillable = [
        'user_id',
        'sended_to_id',
        'topic',
        'message',
        'is_read',
    ];

}
