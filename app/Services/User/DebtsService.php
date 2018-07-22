<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Contracts\User\DebtsService as DebtsServiceInterface;

class DebtsService implements DebtsServiceInterface
{
    /**
     * User that will be used.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    public function __construct(?User $user = null)
    {
        if ($user) {
            $this->actingAs($user);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function actingAs(User $user): DebtsServiceInterface
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addDebt(User $creditor, float $amount): DebtsServiceInterface
    {
        $this->checkUserIsNotNull();

        $receivables = 0;

        if ($debtRow = $this->user->debtors()->where('id', $creditor->id)->first()) {
            $receivables = (float)$debtRow->pivot->amount;
        }

        $difference = $receivables - $amount;

        if ($difference > 0) {
            $creditor->setDebtFor($this->user, $difference);
            $this->user->removeDebtFor($creditor);
        } else {
            $this->user->setDebtFor($creditor, abs($difference));
            $creditor->removeDebtFor($this->user);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addReceivable(User $debtor, float $amount): DebtsServiceInterface
    {
        $this->checkUserIsNotNull();

        $debts = 0;

        if ($debtRow = $this->user->creditors()->where('id', $debtor->id)->first()) {
            $debts = (float)$debtRow->pivot->amount;
        }

        $difference = $amount - $debts;

        if ($difference > 0) {
            $debtor->setDebtFor($this->user, $difference);
            $this->user->removeDebtFor($debtor);
        } else {
            $this->user->setDebtFor($debtor, abs($difference));
            $debtor->removeDebtFor($this->user);
        }

        return $this;
    }

    /**
     * Throw an exception if user was not previously set (by constructor or `actingAs` method).
     *
     * @throws \InvalidArgumentException When user was not set
     */
    protected function checkUserIsNotNull(): void
    {
        if (!$this->user) {
            throw new \InvalidArgumentException('User was not set.');
        }
    }
}
