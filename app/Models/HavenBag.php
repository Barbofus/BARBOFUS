<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HavenBag extends Model
{
    use HasFactory;

    protected $fillable = [
        'haven_bag_theme_id',
        'user_id',
        'name',
        'image_path',
    ];

    /**
     * @return BelongsTo<HavenBagTheme, HavenBag>
     */
    public function havenBags()
    {
        return $this->belongsTo(HavenBag::class);
    }

    /**
     * @return BelongsTo<User, HavenBag>
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
