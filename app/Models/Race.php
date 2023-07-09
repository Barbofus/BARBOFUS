<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = [
        'icon_path',
        'banner_path',
        'name',
    ];

    public $timestamps = false;

    use HasFactory;

    public function Build()
    {
        return $this->hasMany('App\Models\Build');
    }

    public function Skins()
    {
        return $this->hasMany(Skin::class);
    }
}
