<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @var \App\Services\Order\OrderCreateService
     */
    protected $createService;

    /**
     * OrderController constructor.
     *
     * @param \App\Services\Order\OrderCreateService $createService
     */
    public function __construct(\App\Services\Order\OrderCreateService $createService)
    {
        $this->createService = $createService;
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('order.create');
    }

    /**
     * Create new order.
     *
     * @param \App\Http\Requests\Order\CreateOrderRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateOrderRequest $request): RedirectResponse
    {
        $request->merge([
            'user_id' => auth()->id(),
        ]);

        try {
            $this->createService->create($request);
        } catch (\Throwable $throwable) {
            return redirect()->back()
                ->withErrors(__('An unhandled exception occurred.'));
        }

        return redirect()->route('home')
            ->with('success', __('Order has been added successfully.'));
    }
}
