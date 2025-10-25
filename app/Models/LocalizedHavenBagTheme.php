<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LocalizedHavenBagTheme
 *
 * @property int $id
 * @property int $dofus_id
 * @property string $locale
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HavenBagTheme|null $havenBagTheme
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme whereDofusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedHavenBagTheme whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
