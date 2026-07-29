<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LocalizedRace
 *
 * @property int $id
 * @property int $dofus_id
 * @property string $locale
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Race|null $race
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace whereDofusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedRace whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class LocalizedRace extends Model
{
    protected $fillable = [
        'name',
        'locale',
        'dofus_id',
    ];

    /**
     * @return BelongsTo<Race, LocalizedRace>
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
