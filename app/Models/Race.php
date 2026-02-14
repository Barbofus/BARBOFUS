<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Race
 *
 * @property int $id
 * @property string $name
 * @property mixed|null $colors
 * @property mixed|null $heads
 * @property string $ghost_icon_path
 * @property string $colored_icon_path
 * @property int $dofus_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skin> $Skins
 * @property-read int|null $skins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UnitySkin> $UnitySkins
 * @property-read int|null $unity_skins_count
 * @property-read \App\Models\LocalizedRace|null $localizedName
 * @method static \Database\Factories\RaceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Race newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Race newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Race query()
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereColoredIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereColors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereDofusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereGhostIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereHeads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Race whereName($value)
 * @mixin \Eloquent
 */
class Race extends Model
{
    protected $fillable = [
        'icon_path',
        'banner_path',
        'name',
        'colors',
        'heads',
        'bodies',
        'ghost_icon_path',
        'colored_icon_path',
        'dofus_id',
    ];

    public $timestamps = false;

    use HasFactory;

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

    /**
     * @return HasOne<LocalizedRace>
     */
    public function localizedName()
    {
        return $this->hasOne(LocalizedRace::class, 'dofus_id', 'dofus_id')
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
