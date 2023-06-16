<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'skin_id',
        'rank',
        'points',
    ];

    public function Skin() {
        return $this->belongsTo(Skin::class);
    }
}
