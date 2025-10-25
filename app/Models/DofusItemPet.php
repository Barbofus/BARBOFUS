<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DofusItemPet
 *
 * @property-read \App\Models\DofusItemsSubCategorie|null $DofusItemsSubCategorie
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skin> $Skins
 * @property-read int|null $skins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitySkin> $UnitySkins
 * @property-read int|null $unity_skins_count
 * @method static \Database\Factories\DofusItemPetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemPet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemPet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DofusItemPet query()
 * @mixin \Eloquent
 */
class DofusItemPet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dofus_id',
        'level',
        'icon_path',
        'dofus_items_sub_categorie_id',
        'type',
    ];

    /**
     * @return BelongsTo<DofusItemsSubCategorie, DofusItemPet>
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
