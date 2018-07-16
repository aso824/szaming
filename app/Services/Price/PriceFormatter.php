<?php

namespace App\Services\Price;

class PriceFormatter
{
    /**
     * Key used in configuration to store currency code.
     *
     * @var string
     */
    public const PRICE_CONFIG_CURRENCY = 'currency';

    /**
     * Key used in configuration to store decimal separator character.
     *
     * @var string
     */
    public const PRICE_CONFIG_SEPARATOR = 'price_separator';

    /**
     * Key used in configuration to store count of decimal places.
     *
     * @var string
     */
    public const PRICE_CONFIG_DECIMAL_PLACES = 'price_decimal_places';

    /**
     * Currency short code, default is $.
     *
     * @var string
     */
    protected $currency;

    /**
     * Decimal separator character, default is dot.
     *
     * @var string
     */
    protected $separator;

    /**
     * Decimal places, default is 2.
     *
     * @var int
     */
    protected $decimalPlaces;

    /**
     * PriceFormatter constructor.
     */
    public function __construct()
    {
        $this->currency = setting(static::PRICE_CONFIG_CURRENCY, '$');
        $this->separator = setting(static::PRICE_CONFIG_SEPARATOR, '.');
        $this->decimalPlaces = setting(static::PRICE_CONFIG_DECIMAL_PLACES, 2);
    }

    /**
     * Format given price, according to app settings.
     *
     * @param float $value
     *
     * @return string
     */
    public function formatPrice(float $value): string
    {
        return number_format($value, $this->decimalPlaces, $this->separator, '').' '.$this->currency;
    }
}
