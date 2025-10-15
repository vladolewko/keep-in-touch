<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/** Class UserSubscription */
class UserSubscription extends Model
{
    use SoftDeletes;
    use HasFactory;

    /** @var string */
    protected $table      = 'user_subscriptions';
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'subscribed_to_id',
        'is_accepted'
    ];

}
