<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitySkin extends Model
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
        'color_cloth_4',
        'dofus_item_hat_id',
        'dofus_item_cloak_id',
        'dofus_item_shield_id',
        'dofus_item_pet_id',
        'dofus_item_costume_id',
        'dofus_item_wing_id',
        'dofus_item_shoulder_id',
        'user_id',
        'race_id',
        'status',
        'refused_reason',
        'name',
    ];

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
}
