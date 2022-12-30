<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    protected $fillable = [
        'image_path',
        'build_link',
        'race_id',
        'title',
        'ap_nbr',
        'mp_nbr',
        'user_id',
        'is_pvp',
    ];


    use HasFactory;

    public static function boot() {
        parent::boot();

        if(auth()->user()) {
            self::creating(function ($build) {
                $build->user()->associate(auth()->user()->id);
            });
        }
    }

    public function Element()
    {
        return $this->belongsToMany('App\Models\Element');
    }

    public function Race()
    {
        return $this->belongsTo('App\Models\Race');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
