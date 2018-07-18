<?php

namespace App\ViewComposers\User;

use App\Services\Contracts\User\BalanceService;
use App\Services\Price\PriceFormatter;
use Illuminate\View\View;

class BalanceViewComposer
{
    /**
     * BalanceService instance.
     *
     * @var \App\Services\Contracts\User\BalanceService
     */
    protected $balanceService;

    /**
     * PriceFormatter instance.
     *
     * @var \App\Services\Price\PriceFormatter
     */
    protected $priceFormatter;

    /**
     * BalanceViewComposer constructor.
     *
     * @param \App\Services\Contracts\User\BalanceService $balanceService
     * @param \App\Services\Price\PriceFormatter          $priceFormatter
     */
    public function __construct(BalanceService $balanceService, PriceFormatter $priceFormatter)
    {
        $this->balanceService = $balanceService;
        $this->priceFormatter = $priceFormatter;
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('balance', $this->getFormattedBalance());
    }

    /**
     * Get and format user balance.
     *
     * @param float|null $balance
     *
     * @return string
     */
    protected function getFormattedBalance(float $balance = null): string
    {
        $balance = $balance ?? $this->getBalance();

        return $this->priceFormatter->formatPrice($balance);
    }

    /**
     * Get user balance.
     *
     * @return float
     */
    protected function getBalance(): float
    {
        return $this->balanceService->getBalance();
    }
}
