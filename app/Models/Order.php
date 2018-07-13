<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Order.
 *
 * @property-read \App\Models\Shop $shop
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $shop_id
 * @property \Carbon\Carbon $purchased_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePurchasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderPosition[] $orderPositions
 */
class Order extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'purchased_at',
    ];

    /**
     * Get shop where this order was.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get user who make this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all associated order positions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderPositions(): HasMany
    {
        return $this->hasMany(OrderPosition::class);
    }
}
