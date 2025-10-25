<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LocalizedItem
 *
 * @property int $id
 * @property int $dofus_id
 * @property string $locale
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item|null $item
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem whereDofusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalizedItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocalizedItem extends Model
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
        return $this->belongsTo(Item::class);
    }
}
