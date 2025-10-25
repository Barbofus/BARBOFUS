<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Item
 *
 * @property int $id
 * @property int $dofus_id
 * @property int|null $asset_id
 * @property int|null $female_asset_id
 * @property string|null $folder
 * @property int $level
 * @property string $category
 * @property string $subcategory
 * @property string|null $pet_type
 * @property string $icon_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $colorable
 * @property-read string $name
 * @property-read \App\Models\LocalizedItem|null $localizedName
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skin> $skin
 * @property-read int|null $skin_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitySkin> $unitySkin
 * @property-read int|null $unity_skin_count
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereColorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereDofusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereFemaleAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereSubcategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    protected $fillable = [
        'dofus_id',
        'level',
        'category',
        'subcategory',
        'icon_path',
        'pet_type',
        'asset_id',
        'female_asset_id',
        'folder',
        'colorable',
    ];

    /**
     * @return HasMany<Skin>
     */
    public function skin()
    {
        return $this->hasMany(Skin::class);
    }

    /**
     * @return HasMany<UnitySkin>
     */
    public function unitySkin()
    {
        return $this->hasMany(UnitySkin::class);
    }

    /**
     * @return HasOne<LocalizedItem>
     */
    public function localizedName()
    {
        return $this->hasOne(LocalizedItem::class, 'dofus_id', 'dofus_id')
            ->where('locale', app()->getLocale());
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->localizedName?->name ?? 'No name found';
    }
}
