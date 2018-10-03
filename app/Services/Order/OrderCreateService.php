<?php

namespace App\Services\Order;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\Shop;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OrderCreateService
{
    /**
     * Received request object.
     *
     * @var \App\Http\Requests\Order\CreateOrderRequest
     */
    protected $request;

    /**
     * Create new order.
     *
     * @param \App\Http\Requests\Order\CreateOrderRequest $request
     */
    public function create(CreateOrderRequest $request): void
    {
        $this->request = $request;

        if (! is_numeric($this->request->shop_id)) {
            $this->request->merge(['shop' => $this->createShop()->id]);
        }

        $order = $this->createOrderModel();
        $this->createOrderPositions($order);
    }

    /**
     * Create Order model in database.
     *
     * @return \App\Models\Order
     */
    protected function createOrderModel(): Order
    {
        return Order::create([
            'user_id' => $this->request->user_id,
            'shop_id' => $this->request->shop,
            'purchased_at' => Carbon::now(),
        ]);
    }

    /**
     * Create a shop named from the request.
     *
     * @return \App\Models\Shop
     */
    protected function createShop(): Shop
    {
        return Shop::create([
            'name' => $this->request->shop,
        ]);
    }

    /**
     * Create many order positions from the request, attached to given order.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Support\Collection
     */
    protected function createOrderPositions(Order $order): Collection
    {
        $positions = collect();

        foreach ($this->request->orders as $positionData) {
            $positionData['order_id'] = $order->id;

            $position = $this->createSinglePosition($positionData);
            $positions->push($position);
        }

        return $positions;
    }

    /**
     * Create single order position with given data.
     *
     * @param array $positionData
     *
     * @return \App\Models\OrderPosition
     */
    protected function createSinglePosition(array $positionData): OrderPosition
    {
        return OrderPosition::create($positionData);
    }
}
