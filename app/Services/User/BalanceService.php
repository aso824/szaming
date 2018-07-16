<?php

namespace App\Services\User;

use App\Models\User;

class BalanceService
{
    /**
     * The user for whom the account balance will be calculated.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * BalanceService constructor.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user's account balance.
     *
     * @return float
     */
    public function getBalance(): float
    {
        $debts = $this->user->debts()->sum();
        $receivables = $this->user->receivables()->sum();

        return $receivables - $debts;
    }
}
