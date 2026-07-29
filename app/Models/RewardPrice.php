<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RewardPrice
 *
 * @property int $id
 * @property string $rank
 * @property int $points
 *
 * @method static \Database\Factories\RewardPriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RewardPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardPrice wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardPrice whereRank($value)
 *
 * @mixin \Eloquent
 */
class RewardPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'rank',
        'points',
    ];
}
