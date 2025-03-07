<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocalizedHavenBagTheme extends Model
{
    protected $fillable = [
        'name',
        'locale',
        'dofus_id',
    ];

    /**
     * @return BelongsTo<HavenBagTheme, LocalizedHavenBagTheme>
     */
    public function havenBagTheme()
    {
        return $this->belongsTo(HavenBagTheme::class);
    }
}
