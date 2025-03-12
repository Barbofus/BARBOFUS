<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
