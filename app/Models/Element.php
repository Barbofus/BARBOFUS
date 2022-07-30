<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $fillable = [
        'icon_path',
        'name',
    ];

    use HasFactory;
    

    public function Build()
    {
        return $this->belongsToMany('App\Models\Build');
    }
}
