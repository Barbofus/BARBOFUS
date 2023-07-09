<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationPreferences extends Model
{
    //use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_type',
        'value',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
