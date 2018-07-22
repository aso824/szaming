<?php

namespace App\Services\Contracts\Order;

use App\Models\Order;

interface OrderProcessService
{
    /**
     * Set all debts and receivables for given order.
     * Must be called only once, after creating order.
     *
     * @param \App\Models\Order $order
     */
    public function processOrder(Order $order): void;
}
