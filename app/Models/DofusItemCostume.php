<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DofusItemCostume extends Model
{
    protected $fillable = [
        'name',
        'dofus_id',
        'level',
        'icon_path',
        'dofus_items_sub_categorie_id',
    ];

    public function DofusItemsSubCategorie()
    {
        return $this->belongsTo(DofusItemsSubCategorie::class);
    }

    public function Skins()
    {
        return $this->hasMany(Skin::class);
    }
}
