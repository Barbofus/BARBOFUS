<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UnityReward
 *
 * @property int $id
 * @property int $unity_skin_id
 * @property int $rank
 * @property int $points
 * @property-read \App\Models\UnitySkin|null $Skin
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnityReward whereUnitySkinId($value)
 *
 * @mixin \Eloquent
 */
class UnityReward extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'unity_skin_id',
        'rank',
        'points',
    ];

    /**
     * @return BelongsTo<UnitySkin, UnityReward>
     */
    public function Skin()
    {
        return $this->belongsTo(UnitySkin::class);
    }
}
