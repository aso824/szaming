<?php

namespace Tests\Unit\Services\Price;

use App\Services\Price\PriceFormatter;
use Tests\TestCase;

class PriceFormatterTest extends TestCase
{
    public function testWithDefaultConfig(): void
    {
        config()->set('settings.path', storage_path('settings_testing.json'));
        $formatter = app(PriceFormatter::class);

        $this->assertEquals('123.00 $', $formatter->formatPrice(123));
    }

    public function testWithModifiedConfig(): void
    {
        config()->set('settings.path', storage_path('settings_testing.json'));

        setting()->set(PriceFormatter::PRICE_CONFIG_CURRENCY, 'zł');
        setting()->set(PriceFormatter::PRICE_CONFIG_SEPARATOR, ',');
        setting()->set(PriceFormatter::PRICE_CONFIG_DECIMAL_PLACES, 3);

        $formatter = app(PriceFormatter::class);
        unlink(storage_path('settings_testing.json'));

        $this->assertEquals('123,000 zł', $formatter->formatPrice(123));
    }
}
