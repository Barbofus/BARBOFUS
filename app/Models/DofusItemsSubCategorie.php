<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DofusItemsSubCategorie extends Model
{
    use HasFactory;

    public function DofusItemHat()
    {
        return $this->hasMany(DofusItemHat::class);
    }

    public function DofusItemCloak()
    {
        return $this->hasMany(DofusItemCloak::class);
    }

    public function DofusItemShield()
    {
        return $this->hasMany(DofusItemShield::class);
    }

    public function DofusItemCostume()
    {
        return $this->hasMany(DofusItemCostume::class);
    }

    public function DofusItemPet()
    {
        return $this->hasMany(DofusItemPet::class);
    }
}
