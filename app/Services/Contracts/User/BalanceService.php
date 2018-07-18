<?php

namespace App\Services\Contracts\User;

use App\Models\User;

interface BalanceService
{
    /**
     * BalanceService constructor.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user);

    /**
     * Get user's account balance.
     *
     * @return float
     */
    public function getBalance(): float;
}
