<?php

namespace App\Models;

use App\Exceptions\Shopping\InvalidPriceException;
use App\Exceptions\Shopping\InvalidQuantityException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ShoppingPosition.
 *
 * @property-read \App\Models\Shopping $shopping
 * @mixin \Eloquent
 *
 * @property int $id
 * @property int $shopping_id
 * @property string $name
 * @property float $price
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition whereShoppingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingPosition whereUpdatedAt($value)
 */
class ShoppingPosition extends Model
{
    /**
     * Get associated shopping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shopping(): BelongsTo
    {
        return $this->belongsTo(Shopping::class);
    }

    /**
     * Get total price for this position.
     *
     * @throws \App\Exceptions\Shopping\InvalidPriceException
     * @throws \App\Exceptions\Shopping\InvalidQuantityException
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
