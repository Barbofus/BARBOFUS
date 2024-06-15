<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
