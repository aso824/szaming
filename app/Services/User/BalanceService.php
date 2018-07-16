<?php

namespace App\Services\User;

class BalanceService
{
    /**
     * Get user's account balance.
     *
     * @return float
     */
    public function getBalance(): float
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $debts = $user->debts()->sum();
        $receivables = $user->receivables()->sum();

        return $receivables - $debts;
    }
}
