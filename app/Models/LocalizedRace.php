<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocalizedRace extends Model
{
    protected $fillable = [
        'name',
        'locale',
        'dofus_id',
    ];

    /**
     * @return BelongsTo<Item, LocalizedItem>
     */
    public function item()
    {
        return $this->belongsTo(Race::class);
    }
}
