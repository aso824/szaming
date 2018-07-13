<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * App\Models\User.
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $creditors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $debtors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all orders that user created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all users for whom this user has a debt, i.e this user should give `amount` to each user from this collection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function creditors(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'debts', 'debtor_id', 'creditor_id');
    }

    /**
     * Get all users who have a debt for this user, i.e. each user from this collection should give `amount` to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function debtors(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'debts', 'creditor_id', 'debtor_id');
    }

    /**
     * Get all debts, i.e. amount of money that this user should pay to others.
     * Returns collection, where key is user ID and value is amount to pay.
     *
     * @return \Illuminate\Support\Collection
     */
    public function debts(): Collection
    {
        return $this->creditors()->where('amount', '>', 0)->pluck('amount', 'id');
    }

    /**
     * Get all receivables, i.e. amount of money that users should pay to this user.
     * Returns collection, where key is user ID and value is amount to pay.
     *
     * @return \Illuminate\Support\Collection
     */
    public function receivables(): Collection
    {
        return $this->debtors()->where('amount', '>', 0)->pluck('amount', 'id');
    }
}
