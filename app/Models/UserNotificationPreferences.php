<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotificationPreferences extends Model
{
    //use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_type',
        'value',
    ];

    /**
     * @return BelongsTo<User, UserNotificationPreferences>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
