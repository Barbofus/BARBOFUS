<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\HavenBagTheme
 *
 * @property int $id
 * @property int $dofus_id
 * @property string $name
 * @property string $image_path
 * @property string $popocket_icon_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HavenBag> $havenBags
 * @property-read int|null $haven_bags_count
 * @property-read \App\Models\LocalizedHavenBagTheme|null $localizedName
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme whereDofusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme wherePopocketIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBagTheme whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
