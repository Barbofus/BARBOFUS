<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DofusItemsSubCategorie
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DofusItemCloak> $DofusItemCloak
 * @property-read int|null $dofus_item_cloak_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DofusItemCostume> $DofusItemCostume
 * @property-read int|null $dofus_item_costume_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DofusItemHat> $DofusItemHat
 * @property-read int|null $dofus_item_hat_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DofusItemPet> $DofusItemPet
 * @property-read int|null $dofus_item_pet_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DofusItemShield> $DofusItemShield
 * @property-read int|null $dofus_item_shield_count
 * @method static \Database\Factories\DofusItemsSubCategorieFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemsSubCategorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemsSubCategorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemsSubCategorie query()
 * @mixin \Eloquent
 */
class DofusItemsSubCategorie extends Model
{
    use HasFactory;

    /**
     * @return HasMany<DofusItemHat>
     */
    public function DofusItemHat()
    {
        return $this->hasMany(DofusItemHat::class);
    }

    /**
     * @return HasMany<DofusItemCloak>
     */
    public function DofusItemCloak()
    {
        return $this->hasMany(DofusItemCloak::class);
    }

    /**
     * @return HasMany<DofusItemShield>
     */
    public function DofusItemShield()
    {
        return $this->hasMany(DofusItemShield::class);
    }

    /**
     * @return HasMany<DofusItemCostume>
     */
    public function DofusItemCostume()
    {
        return $this->hasMany(DofusItemCostume::class);
    }

    /**
     * @return HasMany<DofusItemPet>
     */
    public function DofusItemPet()
    {
        return $this->hasMany(DofusItemPet::class);
    }
}
