<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
