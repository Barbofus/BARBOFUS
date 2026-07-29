<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Connection
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $access_token
 * @property string $refresh_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Connection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Connection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Connection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connection whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Connection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'access_token',
        'refresh_token',
    ];

    /**
     * @return BelongsTo<User, Connection>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
