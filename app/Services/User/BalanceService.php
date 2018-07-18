<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Contracts\User\BalanceService as BalanceServiceInterface;

class BalanceService implements BalanceServiceInterface
{
    /**
     * The user for whom the account balance will be calculated.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getBalance(): float
    {
        $debts = $this->user->debts()->sum();
        $receivables = $this->user->receivables()->sum();

        return $receivables - $debts;
    }
}
