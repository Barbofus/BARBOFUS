<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnityReward extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'unity_skin_id',
        'rank',
        'points',
    ];

    /**
     * @return BelongsTo<UnitySkin, Reward>
     */
    public function Skin()
    {
        return $this->belongsTo(UnitySkin::class);
    }
}
