<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeavenBag extends Model
{
    use HasFactory;

    protected $fillable = [
        'heaven_bag_theme_id',
        'user_id',
        'name',
        'image_path',
    ];

    /**
     * @return BelongsTo<HeavenBagTheme, HeavenBag>
     */
    public function heavenBags()
    {
        return $this->belongsTo(HeavenBag::class);
    }

    /**
     * @return BelongsTo<User, HeavenBag>
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
