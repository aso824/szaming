<?php

namespace App\Services\Contracts\User;

use App\Models\User;

interface DebtsService
{
    /**
     * DebtsService constructor.
     *
     * @param \App\Models\User|null $user
     */
    public function __construct(?User $user = null);

    /**
     * Act as given user.
     *
     * @param \App\Models\User $user
     *
     * @return \App\Services\Contracts\User\DebtsService
     */
    public function actingAs(User $user): self;

    /**
     * Add debt for current user (this user will have to pay $creditor given $amount).
     *
     * @param \App\Models\User $creditor
     * @param float            $amount
     *
     * @throws \InvalidArgumentException When user was not set
     *
     * @return \App\Services\Contracts\User\DebtsService
     */
    public function addDebt(User $creditor, float $amount): self;

    /**
     * Add receivable for current user (given $debtor will have to pay given $amount to this user).
     *
     * @param \App\Models\User $debtor
     * @param float            $amount
     *
     * @throws \InvalidArgumentException When user was not set
     *
     * @return \App\Services\Contracts\User\DebtsService
     */
    public function addReceivable(User $debtor, float $amount): self;
}
