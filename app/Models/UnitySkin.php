<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UnitySkin
 *
 * @property int $id
 * @property int|null $hat_id
 * @property int|null $cape_id
 * @property int|null $shield_id
 * @property int|null $pet_id
 * @property int|null $mount_id
 * @property int|null $costume_id
 * @property int|null $wings_id
 * @property int|null $shoulderpads_id
 * @property int $user_id
 * @property int|null $race_id
 * @property int $face
 * @property string $image_path
 * @property int|null $gender
 * @property string $color_skin
 * @property string $color_hair
 * @property string $color_cloth_1
 * @property string $color_cloth_2
 * @property string $color_cloth_3
 * @property string $color_cloth_4
 * @property string $color_guild_1
 * @property string $color_guild_2
 * @property string $status
 * @property string|null $refused_reason
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Race|null $Race
 * @property-read \App\Models\User $User
 * @property-read \App\Models\Item|null $cape
 * @property-read \App\Models\Item|null $costume
 * @property-read \App\Models\Item|null $hat
 * @property-read \App\Models\Item|null $mount
 * @property-read \App\Models\Item|null $pet
 * @property-read \App\Models\Item|null $shield
 * @property-read \App\Models\Item|null $shoulderPads
 * @property-read \App\Models\Item|null $wings
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereCapeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereColorCloth1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereColorCloth2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereColorCloth3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereColorCloth4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereColorHair($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereColorSkin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereCostumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereFace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereHatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereMountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereRefusedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereShieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereShoulderpadsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitySkin whereWingsId($value)
 * @mixin \Eloquent
 */
class UnitySkin extends Model
{
    protected $fillable = [
        'face',
        'body',
        'hat_id',
        'cape_id',
        'shield_id',
        'pet_id',
        'costume_id',
        'wings_id',
        'shoulderpads_id',
        'mount_id',
        'image_path',
        'gender',
        'color_skin',
        'color_hair',
        'color_cloth_1',
        'color_cloth_2',
        'color_cloth_3',
        'color_cloth_4',
        'color_guild_1',
        'color_guild_2',
        'user_id',
        'race_id',
        'status',
        'refused_reason',
        'name',
        'chunk_views',
        'detailed_views',
    ];

    protected $casts = [
        'chunk_views' => 'integer',
        'detailed_views' => 'integer',
        'total_views' => 'integer',
    ];

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function hat()
    {
        return $this->belongsTo(Item::class, 'hat_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function cape()
    {
        return $this->belongsTo(Item::class, 'cape_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function shield()
    {
        return $this->belongsTo(Item::class, 'shield_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function pet()
    {
        return $this->belongsTo(Item::class, 'pet_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function costume()
    {
        return $this->belongsTo(Item::class, 'costume_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function wings()
    {
        return $this->belongsTo(Item::class, 'wing_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function shoulderPads()
    {
        return $this->belongsTo(Item::class, 'shoulderpads_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function mount()
    {
        return $this->belongsTo(Item::class, 'mount_id');
    }

    /**
     * @return BelongsTo<User, UnitySkin>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Race, UnitySkin>
     */
    public function Race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Increment chunk views (for lazy loading)
     */
    public function incrementChunkViews(int $count = 1): void
    {
        $this->increment('chunk_views', $count);
    }

    /**
     * Increment detailed views (for show page)
     */
    public function incrementDetailedViews(int $count = 1): void
    {
        $this->increment('detailed_views', $count);
    }
}
