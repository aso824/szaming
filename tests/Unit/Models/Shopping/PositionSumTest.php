<?php

namespace Tests\Unit\Models\Shopping;

use App\Exceptions\Shopping\InvalidPriceException;
use App\Exceptions\Shopping\InvalidQuantityException;
use App\Models\ShoppingPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionSumTest extends TestCase
{
    use RefreshDatabase;

    public function testCorrectSum()
    {
        $position = factory(ShoppingPosition::class)->make([
            'price'    => 9.99,
            'quantity' => 3,
        ]);

        $this->assertEquals(29.97, $position->getSum());
    }

    public function testInvalidPrice()
    {
        $position = factory(ShoppingPosition::class)->make([
            'price'    => -9.99,
            'quantity' => 3,
        ]);

        $this->expectException(InvalidPriceException::class);
        $position->getSum();

    }

    public function testInvalidQuantity()
    {
        $position = factory(ShoppingPosition::class)->make([
            'price'    => 9.99,
            'quantity' => -3,
        ]);

        $this->expectException(InvalidQuantityException::class);
        $position->getSum();
    }
}
