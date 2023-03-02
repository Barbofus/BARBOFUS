<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DofusItemCloak extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dofus_id',
        'level',
        'icon_path',
        'dofus_items_sub_categorie_id',
    ];

    public function DofusItemsSubCategorie(){
        return $this->hasOne(DofusItemsSubCategorie::class);
    }

    public function Skins() {
        return $this->hasMany(Skin::class);
    }
}
