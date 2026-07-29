<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Favorite
 *
 * @property int $id
 * @property int $user_id
 * @property int $item_id
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
    ];

    public $timestamps = false;

    /**
     * Undocumented function
     *
     * @return BelongsTo<User, Favorite>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Item, Favorite>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
