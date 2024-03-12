<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeavenBagTheme extends Model
{
    protected $fillable = [
        'dofus_id',
        'name',
        'image_path',
        'popocket_icon_path',
    ];

    /**
     * @return HasMany<HeavenBag>
     */
    public function heavenBags()
    {
        return $this->hasMany(HeavenBag::class);
    }
}
