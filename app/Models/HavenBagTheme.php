<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HavenBagTheme extends Model
{
    protected $fillable = [
        'dofus_id',
        'name',
        'image_path',
        'popocket_icon_path',
    ];

    /**
     * @return HasMany<HavenBag>
     */
    public function havenBags()
    {
        return $this->hasMany(HavenBag::class);
    }

    /**
     * @return HasOne<LocalizedHavenBagTheme>
     */
    public function localizedName()
    {
        return $this->hasOne(LocalizedHavenBagTheme::class, 'dofus_id', 'dofus_id')
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
