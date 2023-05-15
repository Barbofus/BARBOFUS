<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_id',
        'reward_rank',
        'reward_value'
    ];

    public function Skin() {
        $this->belongsToMany(Skin::class);
    }
}
