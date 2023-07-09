<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property mixed $unreadNotifications
 * @property mixed $notifications
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Role, User>
     */
    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * @return HasMany<Skin>
     */
    public function Skins()
    {
        return $this->hasMany(Skin::class);
    }

    /**
     * @return HasMany<UserNotificationPreferences>
     */
    public function NotificationPreferences()
    {
        return $this->hasMany(UserNotificationPreferences::class);
    }

    /**
     * @return HasMany<Like>
     */
    public function Likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * @return MorphMany<DatabaseNotification>
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }
}
