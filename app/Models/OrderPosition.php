<?php

namespace App\Models;

use App\Exceptions\Order\InvalidPriceException;
use App\Exceptions\Order\InvalidQuantityException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OrderPosition.
 *
 * @property-read \App\Models\Order $order
 * @mixin \Eloquent
 *
 * @property int $id
 * @property int $order_id
 * @property string $name
 * @property float $price
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPosition whereUpdatedAt($value)
 */
class OrderPosition extends Model
{
    /**
     * Get associated order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get all users associated with this order position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'order_position_users'
        );
    }

    /**
     * Get total price for this position.
     *
     * @throws \App\Exceptions\Order\InvalidPriceException
     * @throws \App\Exceptions\Order\InvalidQuantityException
     *
     * @return float
     */
    public function getSum(): float
    {
        if ($this->price <= 0) {
            throw new InvalidPriceException('Price must be positive.');
        }

        if ($this->quantity <= 0) {
            throw new InvalidQuantityException('Quantity must be positive.');
        }

        return $this->price * $this->quantity;
    }
}
