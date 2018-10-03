<?php

namespace App\Http\Controllers;

use App\Http\ViewModels\Balance\BalanceViewModel;
use Illuminate\View\View;

class BalanceController extends Controller
{
    /**
     * Show user balance details.
     *
     * @param \App\Http\ViewModels\Balance\BalanceViewModel $balanceViewModel
     *
     * @return \Illuminate\View\View
     */
    public function index(BalanceViewModel $balanceViewModel): View
    {
        return view('balance.index', compact('balanceViewModel'));
    }
}