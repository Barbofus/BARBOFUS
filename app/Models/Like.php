<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_id',
        'user_id',
    ];

    /**
     * @return BelongsTo<Skin, Like>
     */
    public function Skin()
    {
        return $this->belongsTo(Skin::class);
    }

    /**
     * @return BelongsTo<User, Like>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
