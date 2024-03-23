<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HavenBag extends Model
{
    use HasFactory;

    protected $fillable = [
        'haven_bag_theme_id',
        'user_id',
        'name',
        'image_path',
        'status',
    ];

    /**
     * @return BelongsTo<HavenBagTheme, HavenBag>
     */
    public function havenBag()
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
