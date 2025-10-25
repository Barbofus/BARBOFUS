<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Skin
 *
 * @property int $id
 * @property int|null $hat_id
 * @property int|null $cape_id
 * @property int|null $shield_id
 * @property int|null $pet_id
 * @property int|null $costume_id
 * @property int $user_id
 * @property int $race_id
 * @property int $face
 * @property string $image_path
 * @property string $gender
 * @property string $color_skin
 * @property string $color_hair
 * @property string $color_cloth_1
 * @property string $color_cloth_2
 * @property string $color_cloth_3
 * @property string $status
 * @property string|null $refused_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property-read \App\Models\DofusItemCloak|null $DofusItemCloak
 * @property-read \App\Models\DofusItemCostume|null $DofusItemCostume
 * @property-read \App\Models\DofusItemHat|null $DofusItemHat
 * @property-read \App\Models\DofusItemPet|null $DofusItemPet
 * @property-read \App\Models\DofusItemShield|null $DofusItemShield
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $Likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\Race $Race
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reward> $Rewards
 * @property-read int|null $rewards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reward> $RewardsWinners
 * @property-read int|null $rewards_winners_count
 * @property-read \App\Models\User $User
 * @property-read \App\Models\Item|null $cape
 * @property-read \App\Models\Item|null $costume
 * @property-read \App\Models\Item|null $hat
 * @property-read \App\Models\Item|null $pet
 * @property-read \App\Models\Item|null $shield
 * @method static \Database\Factories\SkinFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Skin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereCapeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereColorCloth1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereColorCloth2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereColorCloth3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereColorHair($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereColorSkin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereCostumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereFace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereHatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereRefusedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereShieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skin whereUserId($value)
 * @mixin \Eloquent
 */
class Skin extends Model
{
    protected $fillable = [
        'face',
        'hat_id',
        'cape_id',
        'shield_id',
        'pet_id',
        'costume_id',
        'image_path',
        'gender',
        'color_skin',
        'color_hair',
        'color_cloth_1',
        'color_cloth_2',
        'color_cloth_3',
        'dofus_item_hat_id',
        'dofus_item_cloak_id',
        'dofus_item_shield_id',
        'dofus_item_pet_id',
        'dofus_item_costume_id',
        'user_id',
        'race_id',
        'status',
        'refused_reason',
        'name',
    ];

    use HasFactory;

    /**
     * @return BelongsTo<Item, Skin>
     */
    public function hat()
    {
        return $this->belongsTo(Item::class, 'hat_id');
    }

    /**
     * @return BelongsTo<Item, Skin>
     */
    public function cape()
    {
        return $this->belongsTo(Item::class, 'cape_id');
    }

    /**
     * @return BelongsTo<Item, Skin>
     */
    public function shield()
    {
        return $this->belongsTo(Item::class, 'shield_id');
    }

    /**
     * @return BelongsTo<Item, Skin>
     */
    public function pet()
    {
        return $this->belongsTo(Item::class, 'pet_id');
    }

    /**
     * @return BelongsTo<Item, Skin>
     */
    public function costume()
    {
        return $this->belongsTo(Item::class, 'costume_id');
    }

    /**
     * @return BelongsTo<DofusItemHat, Skin>
     */
    public function DofusItemHat()
    {
        return $this->belongsTo(DofusItemHat::class);
    }

    /**
     * @return BelongsTo<DofusItemCloak, Skin>
     */
    public function DofusItemCloak()
    {
        return $this->belongsTo(DofusItemCloak::class);
    }

    /**
     * @return BelongsTo<DofusItemShield, Skin>
     */
    public function DofusItemShield()
    {
        return $this->belongsTo(DofusItemShield::class);
    }

    /**
     * @return BelongsTo<DofusItemCostume, Skin>
     */
    public function DofusItemCostume()
    {
        return $this->belongsTo(DofusItemCostume::class);
    }

    /**
     * @return BelongsTo<DofusItemPet, Skin>
     */
    public function DofusItemPet()
    {
        return $this->belongsTo(DofusItemPet::class);
    }

    /**
     * @return BelongsTo<User, Skin>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Race, Skin>
     */
    public function Race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * @return HasMany<Reward>
     */
    public function Rewards()
    {
        return $this->hasMany(Reward::class)->orderByDesc('points');
    }

    /**
     * @return HasMany<Reward>
     */
    public function RewardsWinners()
    {
        return $this->hasMany(Reward::class)->orderByDesc('created_at');
    }

    /**
     * @return HasMany<Like>
     */
    public function Likes()
    {
        return $this->hasMany(Like::class);
    }
}
