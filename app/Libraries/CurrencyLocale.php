<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;

final class CurrencyLocale
{
    private const CURRENCIES = [
        'AU' => ['AUD', '$'],
        'US' => ['USD', '$'],
        'CA' => ['CAD', '$'],
        'IN' => ['INR', '₹'],
        'GB' => ['GBP', '£'],
        'EU' => ['EUR', '€'],
    ];

    private const EURO_COUNTRIES = [
        'AT', 'BE', 'BG', 'CY', 'DE', 'EE', 'ES', 'FI', 'FR', 'GR',
        'HR', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PT', 'SI', 'SK',
    ];

    /**
     * @return array{country: string, currency: string, symbol: string}|null
     */
    public static function forCountry(string $countryCode): ?array
    {
        $countryCode = strtoupper(trim($countryCode));
        if (in_array($countryCode, self::EURO_COUNTRIES, true)) {
            return [
                'country'  => $countryCode,
                'currency' => 'EUR',
                'symbol'   => '€',
            ];
        }

        if (! isset(self::CURRENCIES[$countryCode])) {
            return null;
        }

        return [
            'country'  => $countryCode,
            'currency' => self::CURRENCIES[$countryCode][0],
            'symbol'   => self::CURRENCIES[$countryCode][1],
        ];
    }

    /**
     * @return array{country: string, currency: string, symbol: string}|null
     */
    public static function forCurrency(string $currencyCode): ?array
    {
        $currencyCode = strtoupper(trim($currencyCode));
        foreach (self::CURRENCIES as $countryCode => [$currency, $symbol]) {
            if ($currencyCode === $currency) {
                return [
                    'country'  => $countryCode,
                    'currency' => $currency,
                    'symbol'   => $symbol,
                ];
            }
        }

        return null;
    }

    public static function exchangeRate(string $currencyCode, ?BaseConnection $database = null): ?float
    {
        if ($currencyCode === 'AUD') {
            return 1.0;
        }

        $database ??= db_connect();
        $latestRates = $database->table('tbl_currency_exchaged_value')
            ->select('conversion_rates')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        if ($latestRates === null) {
            return null;
        }

        $rates = json_decode((string) $latestRates->conversion_rates, true);
        if (! is_array($rates) || ! isset($rates[$currencyCode]) || ! is_numeric($rates[$currencyCode])) {
            return null;
        }

        $rate = (float) $rates[$currencyCode];

        return $rate > 0 ? $rate : null;
    }

    /**
     * @return array{
     *     currency_code_session: string,
     *     currency_country_code: string,
     *     currency_symbol_session: string,
     *     currency_value_session: float,
     *     country_ip_checked: int
     * }|null
     */
    public static function sessionData(string $countryCode, ?BaseConnection $database = null): ?array
    {
        $selection = self::forCountry($countryCode);
        if ($selection === null) {
            return null;
        }

        $rate = self::exchangeRate($selection['currency'], $database);
        if ($rate === null) {
            return null;
        }

        return [
            'currency_code_session'   => $selection['currency'],
            'currency_country_code'   => $selection['country'],
            'currency_symbol_session' => $selection['symbol'],
            'currency_value_session'  => $rate,
            'country_ip_checked'      => 1,
        ];
    }
}
