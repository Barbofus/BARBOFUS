<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_id',
        'reward_price_id'
    ];

    public function Skin() {
        return $this->belongsTo(Skin::class);
    }

    public function RewardPrice() {
        return $this->belongsTo(RewardPrice::class);
    }
}
