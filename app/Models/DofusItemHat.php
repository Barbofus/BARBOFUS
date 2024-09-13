<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DofusItemHat extends Model
{
    protected $fillable = [
        'name',
        'dofus_id',
        'level',
        'icon_path',
        'dofus_items_sub_categorie_id',
    ];

    /**
     * @return BelongsTo<DofusItemsSubCategorie, DofusItemHat>
     */
    public function DofusItemsSubCategorie()
    {
        return $this->belongsTo(DofusItemsSubCategorie::class);
    }

    /**
     * @return HasMany<Skin>
     */
    public function Skins()
    {
        return $this->hasMany(Skin::class);
    }

    /**
     * @return HasMany<UnitySkin>
     */
    public function UnitySkins()
    {
        return $this->hasMany(UnitySkin::class);
    }
}
