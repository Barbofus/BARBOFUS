<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
