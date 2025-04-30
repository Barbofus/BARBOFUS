<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitySkin extends Model
{
    protected $fillable = [
        'face',
        'hat_id',
        'cape_id',
        'shield_id',
        'pet_id',
        'costume_id',
        'wings_id',
        'shoulderpads_id',
        'mount_id',
        'image_path',
        'gender',
        'color_skin',
        'color_hair',
        'color_cloth_1',
        'color_cloth_2',
        'color_cloth_3',
        'color_cloth_4',
        'user_id',
        'race_id',
        'status',
        'refused_reason',
        'name',
    ];

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function hat()
    {
        return $this->belongsTo(Item::class, 'hat_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function cape()
    {
        return $this->belongsTo(Item::class, 'cape_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function shield()
    {
        return $this->belongsTo(Item::class, 'shield_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function pet()
    {
        return $this->belongsTo(Item::class, 'pet_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function costume()
    {
        return $this->belongsTo(Item::class, 'costume_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function wings()
    {
        return $this->belongsTo(Item::class, 'wing_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function shoulderPads()
    {
        return $this->belongsTo(Item::class, 'shoulderpads_id');
    }

    /**
     * @return BelongsTo<Item, UnitySkin>
     */
    public function mount()
    {
        return $this->belongsTo(Item::class, 'mount_id');
    }


    /**
     * @return BelongsTo<User, UnitySkin>
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Race, UnitySkin>
     */
    public function Race()
    {
        return $this->belongsTo(Race::class);
    }
}
