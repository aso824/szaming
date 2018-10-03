<?php

namespace App\Http\ViewModels\Balance;

use App\Models\User;
use App\Services\Price\PriceFormatter;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Collection;

class BalanceViewModel
{
    /**
     * @var \App\Services\Price\PriceFormatter
     */
    protected $priceFormatter;

    /**
     * Current logged user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected $currentUser;

    /**
     * BalanceViewModel constructor.
     *
     * @param \App\Services\Price\PriceFormatter $priceFormatter
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function __construct(PriceFormatter $priceFormatter, UserContract $user)
    {
        $this->priceFormatter = $priceFormatter;

        $this->currentUser = $user;
    }

    /**
     * Get current logged user instance.
     *
     * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function getUser(): UserContract
    {
        return $this->currentUser;
    }

    /**
     * Get collection of users who have a debt for current user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDebts(): Collection
    {
        return $this->getUser()->debtors()->get()->sortByDesc(function (User $debtor) {
            return $debtor->pivot->amount;
        });
    }

    /**
     * Get collection of users whom current user has a debt.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCredits(): Collection
    {
        return $this->getUser()->creditors()->get()->sortByDesc(function (User $creditor) {
            return $creditor->pivot->amount;
        });
    }

    /**
     * @param float $price
     *
     * @return string
     */
    public function formatPrice(float $price): string
    {
        return $this->priceFormatter->formatPrice($price);
    }
}
