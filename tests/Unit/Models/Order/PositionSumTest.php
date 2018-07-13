<?php

namespace Tests\Unit\Models\Order;

use App\Exceptions\Order\InvalidPriceException;
use App\Exceptions\Order\InvalidQuantityException;
use App\Models\OrderPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionSumTest extends TestCase
{
    use RefreshDatabase;

    public function testCorrectSum()
    {
        $position = factory(OrderPosition::class)->make([
            'price'    => 9.99,
            'quantity' => 3,
        ]);

        $this->assertEquals(29.97, $position->getSum());
    }

    public function testInvalidPrice()
    {
        $position = factory(OrderPosition::class)->make([
            'price'    => -9.99,
            'quantity' => 3,
        ]);

        $this->expectException(InvalidPriceException::class);
        $position->getSum();
    }

    public function testInvalidQuantity()
    {
        $position = factory(OrderPosition::class)->make([
            'price'    => 9.99,
            'quantity' => -3,
        ]);

        $this->expectException(InvalidQuantityException::class);
        $position->getSum();
    }
}
