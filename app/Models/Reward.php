<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Reward
 *
 * @property int $id
 * @property int $skin_id
 * @property int $rank
 * @property int $points
 * @property-read \App\Models\Skin $Skin
 *
 * @method static \Database\Factories\RewardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reward query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereSkinId($value)
 *
 * @mixin \Eloquent
 */
class Reward extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'skin_id',
        'rank',
        'points',
    ];

    /**
     * @return BelongsTo<Skin, Reward>
     */
    public function Skin()
    {
        return $this->belongsTo(Skin::class);
    }
}
