<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
