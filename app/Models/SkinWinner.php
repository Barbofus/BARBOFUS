<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SkinWinner
 *
 * @property int $id
 * @property int $skin_id
 * @property int $reward_id
 * @property string $user_name
 * @property string $image_path
 * @property int $weekly_likes
 * @property string|null $skin_name
 *
 * @method static \Database\Factories\SkinWinnerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereRewardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereSkinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereSkinName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkinWinner whereWeeklyLikes($value)
 *
 * @mixin \Eloquent
 */
class SkinWinner extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'skin_id',
        'user_name',
        'image_path',
        'weekly_likes',
        'reward_id',
        'skin_name',
    ];
}
