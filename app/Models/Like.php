<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_id',
        'user_id',
    ];

    public function Skin()
    {
        $this->belongsTo(Skin::class);
    }

    public function User()
    {
        $this->belongsTo(User::class);
    }
}
