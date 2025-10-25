<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\HavenBag
 *
 * @property int $id
 * @property int $haven_bag_theme_id
 * @property int $user_id
 * @property string|null $name
 * @property string $image_path
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $refused_reason
 * @property-read \App\Models\HavenBagTheme $havenBagTheme
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\HavenBagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag query()
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereHavenBagThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereRefusedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HavenBag whereUserId($value)
 * @mixin \Eloquent
 */
class HavenBag extends Model
{
    use HasFactory;

    protected $fillable = [
        'haven_bag_theme_id',
        'user_id',
        'name',
        'image_path',
        'status',
        'refused_reason',
    ];

    /**
     * @return BelongsTo<HavenBagTheme, HavenBag>
     */
    public function havenBagTheme()
    {
        return $this->belongsTo(HavenBagTheme::class);
    }

    /**
     * @return BelongsTo<User, HavenBag>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
