<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserNotificationPreferences
 *
 * @property int $id
 * @property int $user_id
 * @property string $notification_type
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences whereNotificationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotificationPreferences whereValue($value)
 * @mixin \Eloquent
 */
class UserNotificationPreferences extends Model
{
    // use HasFactory;

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
