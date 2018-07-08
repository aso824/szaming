<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Shopping
 *
 * @property-read \App\Models\Shop $shop
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $user_id
 * @property int|null $shop_id
 * @property \Carbon\Carbon $purchased_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopping wherePurchasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopping whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopping whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopping whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShoppingPosition[] $shoppingPositions
 */
class Shopping extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'purchased_at'
    ];

    /**
     * Get shop where this shopping was.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get user who make this shopping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all associated shopping positions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shoppingPositions(): HasMany
    {
        return $this->hasMany(ShoppingPosition::class);
    }
}
