<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Connection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'access_token',
        'refresh_token',
    ];

    /**
     * @return BelongsTo<User, Connection>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
