<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DofusItemsSubCategorie extends Model
{
    use HasFactory;

    public function DofusItemHat(){
        return $this->hasMany('App\Models\DofusItemHat');
    }

    public function DofusItemCloak(){
        return $this->hasMany('App\Models\DofusItemCloak');
    }

    public function DofusItemShield(){
        return $this->hasMany('App\Models\DofusItemShield');
    }

    public function DofusItemCostume(){
        return $this->hasMany('App\Models\DofusItemCostume');
    }

    public function DofusItemPet(){
        return $this->hasMany('App\Models\DofusItemPet');
    }
}
