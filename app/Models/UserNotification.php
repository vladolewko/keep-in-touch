<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/** class UserNotification */
class UserNotification extends Model
{
    use SoftDeletes, HasFactory;

    /** @var string */
    protected $table    = 'user_notifications';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'sent_to_id',
        'topic',
        'message',
        'is_read',
    ];

}
