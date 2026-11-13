<?php

namespace App\Filters;

use App\Libraries\CurrencyLocale;
use App\Libraries\GeoIpCountryLocator;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

final class CurrencyLocalizationFilter implements FilterInterface
{
    private const DEFAULT_COUNTRY = 'AU';

    public function before(RequestInterface $request, $arguments = null)
    {
        if (strtoupper($request->getMethod()) !== 'GET') {
            return null;
        }

        $session = service('session');
        if ((int) $session->get('country_ip_checked') === 1) {
            return null;
        }

        $path = strtolower(trim($request->getUri()->getPath(), '/'));
        if (
            $path === 'admin'
            || str_starts_with($path, 'admin/')
            || in_array($path, ['login', 'checklogin', 'login_error', 'admin-signup', 'logoutadmin'], true)
        ) {
            return null;
        }

        $defaultCountry = strtoupper(trim((string) env('currency.defaultCountryCode', self::DEFAULT_COUNTRY)));
        if (CurrencyLocale::forCountry($defaultCountry) === null) {
            $defaultCountry = self::DEFAULT_COUNTRY;
        }

        $countryCode = $this->detectCountry($request) ?? $defaultCountry;
        $currencyData = CurrencyLocale::sessionData($countryCode);

        if ($currencyData === null) {
            log_message('warning', 'Unable to initialize the detected storefront currency; using the configured default.');
            $currencyData = CurrencyLocale::sessionData($defaultCountry);
        }

        if ($currencyData === null) {
            log_message('error', 'Unable to initialize storefront currency. No exchange rate is available for the configured default.');

            return null;
        }

        $session->set($currencyData);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function detectCountry(RequestInterface $request): ?string
    {
        $databasePath = WRITEPATH . 'geoip' . DIRECTORY_SEPARATOR . 'GeoLite2-Country.mmdb';

        return (new GeoIpCountryLocator($databasePath))->countryCode($request->getIPAddress());
    }
}
