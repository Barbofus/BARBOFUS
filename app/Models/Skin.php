<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skin extends Model
{
    protected $fillable = [
        'face',
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
    ];

    use HasFactory;

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
