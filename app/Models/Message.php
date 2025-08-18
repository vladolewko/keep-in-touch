<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'email',
        'message',
        'status',
        'manager_id',
        'answer',
        ];
}
