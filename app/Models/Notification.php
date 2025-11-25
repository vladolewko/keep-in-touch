<?php

namespace App\Models;

use App\Enums\NotificationTopicEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/** class UserNotification */
class Notification extends Model
{
    use SoftDeletes, HasFactory;

    /** @var string */
    protected $table = 'notifications';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'sent_to_id',
        'topic',
        'message',
        'is_read',
    ];

    /** @var class-string[] */
    protected $casts = [
        'is_read' => 'boolean',
        'topic'   => NotificationTopicEnum::class,
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
