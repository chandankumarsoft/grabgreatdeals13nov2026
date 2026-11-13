<?php

use App\Libraries\GeoIpCountryLocator;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class GeoIpCountryLocatorTest extends CIUnitTestCase
{
    public function testRejectsPrivateAndReservedAddresses(): void
    {
        $locator = new GeoIpCountryLocator(WRITEPATH . 'missing-geolite.mmdb');

        $this->assertNull($locator->countryCode('127.0.0.1'));
        $this->assertNull($locator->countryCode('203.0.113.1'));
    }

    public function testMissingDatabaseFallsBackWithoutCountry(): void
    {
        $locator = new GeoIpCountryLocator(WRITEPATH . 'missing-geolite.mmdb');

        $this->assertNull($locator->countryCode('8.8.8.8'));
    }
}
