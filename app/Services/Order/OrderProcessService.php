<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Services\Contracts\Order\OrderProcessService as OrderProcessServiceInterface;
use App\Services\Contracts\User\DebtsService;
use Illuminate\Support\Collection;

class OrderProcessService implements OrderProcessServiceInterface
{
    /**
     * Service that will be used for changing users debts.
     *
     * @var \App\Services\Contracts\User\DebtsService
     */
    protected $debtsService;

    /**
     * OrderProcessService constructor.
     *
     * @param \App\Services\Contracts\User\DebtsService $debtsService
     */
    public function __construct(DebtsService $debtsService)
    {
        $this->debtsService = $debtsService;
    }

    /**
     * {@inheritdoc}
     */
    public function processOrder(Order $order): void
    {
        $debts = $this->sumUsersDebts($order->orderPositions);

        $this->debtsService->actingAs($order->user);

        $this->setUsersDebts($debts);
    }

    /**
     * Iterate over given order positions and sum debts for each user.
     *
     * @param \Illuminate\Support\Collection $orderPositions
     *
     * @return \Illuminate\Support\Collection
     */
    protected function sumUsersDebts(Collection $orderPositions): Collection
    {
        $debts = new Collection();

        /** @var \App\Models\OrderPosition $position */
        foreach ($orderPositions as $position) {
            $sumPart = $position->getSum() / $position->users()->count();

            /** @var \App\Models\User $user */
            foreach ($position->users as $user) {
                if ($foundUser = $debts->keyBy('id')->get($user->id)) {
                    $foundUser->debtToBeAdded += $sumPart;
                } else {
                    $user->debtToBeAdded = $sumPart;
                    $debts->push($user);
                }
            }
        }

        return $debts;
    }

    /**
     * Set debts for users from order.
     *
     * @param \Illuminate\Support\Collection $debts
     */
    protected function setUsersDebts(Collection $debts): void
    {
        foreach ($debts as $debtor) {
            $this->debtsService->addReceivable($debtor, $debtor->debtToBeAdded);
        }
    }
}
