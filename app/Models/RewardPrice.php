<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'rank',
        'points',
    ];
}
