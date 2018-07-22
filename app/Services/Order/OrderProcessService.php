<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\User;
use App\Services\Contracts\Order\OrderProcessService as OrderProcessServiceInterface;
use Illuminate\Support\Collection;

class OrderProcessService implements OrderProcessServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public static function processOrder(Order $order): void
    {
        $debts = static::sumUsersDebts($order->orderPositions);

        static::setUsersDebts($order->user_id, $debts);
    }

    /**
     * Iterate over given order positions and sum debts for each user.
     *
     * @param \Illuminate\Support\Collection $orderPositions
     *
     * @return array
     */
    protected static function sumUsersDebts(Collection $orderPositions): array
    {
        $debts = [];

        /** @var \App\Models\OrderPosition $position */
        foreach ($orderPositions as $position) {
            $sumPart = $position->getSum() / $position->users()->count();

            /** @var \App\Models\User $user */
            foreach ($position->users as $user) {
                if (! array_key_exists($user->id, $debts)) {
                    $debts[$user->id] = $sumPart;
                } else {
                    $debts[$user->id] += $sumPart;
                }
            }
        }

        return $debts;
    }

    /**
     * Set debts for users from order.
     *
     * @param int   $creditorId
     * @param array $debts
     */
    protected static function setUsersDebts(int $creditorId, array $debts): void
    {
        /** @var \App\Models\User $creditor */
        $creditor = User::findOrFail($creditorId);
        $creditorDebts = $creditor->debts();

        foreach ($debts as $userId => $sum) {
            $debtForThisUser = $creditorDebts[$userId] ?? 0;
            $finalBalance = $sum - $debtForThisUser;

            $finalBalance = round($finalBalance, 4);

            /** @var \App\Models\User $user */
            $user = User::findOrFail($userId);

            if ($finalBalance > 0) {
                $user->setDebtFor($creditor, $finalBalance);
                $creditor->removeDebtFor($user);
            } else {
                $creditor->setDebtFor($user, abs($finalBalance));
                $user->removeDebtFor($creditor);
            }
        }
    }
}
