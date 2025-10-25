<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UnityLike
 *
 * @property int $id
 * @property int $unity_skin_id
 * @property int|null $user_id
 * @property string|null $ip_adress
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\UnitySkin|null $Skin
 * @property-read \App\Models\User|null $User
 * @method static \Database\Factories\UnityLikeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike whereIpAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike whereUnitySkinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityLike whereUserId($value)
 * @mixin \Eloquent
 */
class UnityLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'unity_skin_id',
        'user_id',
        'ip_adress',
    ];

    /**
     * @return BelongsTo<UnitySkin, UnityLike>
     */
    public function Skin()
    {
        return $this->belongsTo(UnitySkin::class);
    }

    /**
     * @return BelongsTo<User, UnityLike>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
