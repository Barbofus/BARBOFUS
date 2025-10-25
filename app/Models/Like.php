<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Like
 *
 * @property int $id
 * @property int $skin_id
 * @property int|null $user_id
 * @property string|null $ip_adress
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Skin $Skin
 * @property-read \App\Models\User|null $User
 * @method static \Database\Factories\LikeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereIpAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereSkinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereUserId($value)
 * @mixin \Eloquent
 */
class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_id',
        'user_id',
        'ip_adress',
    ];

    /**
     * @return BelongsTo<Skin, Like>
     */
    public function Skin()
    {
        return $this->belongsTo(Skin::class);
    }

    /**
     * @return BelongsTo<User, Like>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
