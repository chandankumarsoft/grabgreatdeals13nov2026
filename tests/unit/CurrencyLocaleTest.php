<?php

use App\Libraries\CurrencyLocale;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class CurrencyLocaleTest extends CIUnitTestCase
{
    public function testMapsSupportedCountriesToCurrencies(): void
    {
        $this->assertSame(
            ['country' => 'US', 'currency' => 'USD', 'symbol' => '$'],
            CurrencyLocale::forCountry('us'),
        );
        $this->assertSame(
            ['country' => 'FR', 'currency' => 'EUR', 'symbol' => '€'],
            CurrencyLocale::forCountry('FR'),
        );
    }

    public function testMapsManualCurrencySelectionToItsCountry(): void
    {
        $this->assertSame(
            ['country' => 'EU', 'currency' => 'EUR', 'symbol' => '€'],
            CurrencyLocale::forCurrency('eur'),
        );
    }

    public function testRejectsUnsupportedCountryAndCurrency(): void
    {
        $this->assertNull(CurrencyLocale::forCountry('ZZ'));
        $this->assertNull(CurrencyLocale::forCurrency('JPY'));
    }
}
