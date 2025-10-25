<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DofusItemCostume
 *
 * @property-read \App\Models\DofusItemsSubCategorie|null $DofusItemsSubCategorie
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skin> $Skins
 * @property-read int|null $skins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitySkin> $UnitySkins
 * @property-read int|null $unity_skins_count
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemCostume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemCostume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemCostume query()
 * @mixin \Eloquent
 */
class DofusItemCostume extends Model
{
    protected $fillable = [
        'name',
        'dofus_id',
        'level',
        'icon_path',
        'dofus_items_sub_categorie_id',
    ];

    /**
     * @return BelongsTo<DofusItemsSubCategorie, DofusItemCostume>
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
