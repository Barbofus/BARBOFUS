<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnityLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'unity_skin_id',
        'user_id',
        'ip_adress',
    ];

    /**
     * @return BelongsTo<UnitySkin, UnityLike>
     */
    public function Skin()
    {
        return $this->belongsTo(UnitySkin::class);
    }

    /**
     * @return BelongsTo<User, UnityLike>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
