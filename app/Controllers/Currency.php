<?php

namespace App\Controllers;

use App\Libraries\CurrencyLocale;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use RuntimeException;

class Currency extends BaseController
{
    public function currencyConverter(): ResponseInterface
    {
        $currencyCode = strtoupper(trim((string) $this->request->getPost('currency_code')));
        $countryCode = strtoupper(trim((string) $this->request->getPost('currencycountrycode')));
        $countryIpChecked = (string) $this->request->getPost('country_ip_checked') === '1';

        if (! $countryIpChecked) {
            $detectedCountry = strtoupper(trim((string) env('currency.defaultCountryCode', 'AU')));
            if (CurrencyLocale::forCountry($detectedCountry) !== null) {
                $countryCode = $detectedCountry;
                $currencyCode = CurrencyLocale::forCountry($detectedCountry)['currency'];
            }
        }

        $selectedCurrency = CurrencyLocale::forCurrency($currencyCode);

        if ($selectedCurrency === null || ($countryCode !== '' && $countryCode !== $selectedCurrency['country'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Select a valid currency and country.',
            ]);
        }
        $countryCode = $selectedCurrency['country'];

        $currencyData = CurrencyLocale::sessionData($countryCode);
        if ($currencyData === null || $currencyData['currency_code_session'] !== $currencyCode) {
            return $this->response->setStatusCode(503)->setJSON([
                'error' => 'Exchange rates are not available for the selected currency.',
            ]);
        }

        service('session')->set($currencyData);

        return $this->response->setJSON(['success' => 1]);
    }

    public function findcountryname(): string
    {
        $sessionCountry = strtoupper(trim((string) service('session')->get('currency_country_code')));
        if (CurrencyLocale::forCountry($sessionCountry) !== null) {
            return $sessionCountry;
        }

        $countryCode = strtoupper(trim((string) env('currency.defaultCountryCode', 'AU')));

        return CurrencyLocale::forCountry($countryCode) === null ? 'AU' : $countryCode;
    }

    public function exchangedRateAddedCrone(): ResponseInterface
    {
        $configuredToken = (string) env('jobs.cronToken', '');
        $requestToken = (string) $this->request->getHeaderLine('X-Cron-Token');
        if ($configuredToken === '' || $requestToken === '' || ! hash_equals($configuredToken, $requestToken)) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden.']);
        }

        $apiKey = trim((string) env('currency.exchangeRateApiKey', ''));
        if ($apiKey === '') {
            return $this->response->setStatusCode(503)->setJSON([
                'error' => 'Exchange-rate updates are not configured.',
            ]);
        }

        try {
            $response = service('curlrequest')->get(
                'https://v6.exchangerate-api.com/v6/' . rawurlencode($apiKey) . '/latest/AUD',
                ['timeout' => 15, 'http_errors' => false],
            );
        } catch (HTTPException $exception) {
            log_message('error', 'Exchange-rate provider request failed: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return $this->response->setStatusCode(502)->setJSON([
                'error' => 'Exchange-rate provider is unavailable.',
            ]);
        }

        $ratesData = json_decode((string) $response->getBody(), true);
        if (
            $response->getStatusCode() < 200
            || $response->getStatusCode() >= 300
            || ! is_array($ratesData)
            || ($ratesData['result'] ?? null) !== 'success'
            || ! is_array($ratesData['conversion_rates'] ?? null)
        ) {
            log_message('error', 'Exchange-rate provider returned an invalid response.');

            return $this->response->setStatusCode(502)->setJSON([
                'error' => 'Exchange-rate provider returned invalid data.',
            ]);
        }

        if (! db_connect()->table('tbl_currency_exchaged_value')->insert([
            'base_code'         => 'AUD',
            'conversion_rates'  => json_encode($ratesData['conversion_rates'], JSON_THROW_ON_ERROR),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ])) {
            throw new RuntimeException('Unable to store exchange rates.');
        }

        return $this->response->setJSON(['success' => 1]);
    }
}
