<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skin extends Model
{
    protected $fillable = [
        'face',
        'image_path',
        'gender',
        'color_skin',
        'color_hair',
        'color_cloth_1',
        'color_cloth_2',
        'color_cloth_3',
    ];


    use HasFactory;

    public function DofusItemHat() {
        return $this->belongsTo(DofusItemHat::class);
    }

    public function DofusItemCloak() {
        return $this->belongsTo(DofusItemCloak::class);
    }

    public function DofusItemShield() {
        return $this->belongsTo(DofusItemShield::class);
    }

    public function DofusItemCostume() {
        return $this->belongsTo(DofusItemCostume::class);
    }

    public function DofusItemPet() {
        return $this->belongsTo(DofusItemPet::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Race() {
        return $this->belongsTo(Race::class);
    }
}