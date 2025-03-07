<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Race extends Model
{
    protected $fillable = [
        'icon_path',
        'banner_path',
        'name',
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
     * @return HasOne<LocalizedItem>
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
