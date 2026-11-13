<?php

if (! function_exists('admin_url')) {
    function admin_url(string $path = ''): string
    {
        $path = ltrim($path, '/');

        return base_url('admin' . ($path === '' ? '' : '/' . $path));
    }
}

if (! function_exists('legacy_localize_content_urls')) {
    function legacy_localize_content_urls(?string $content): string
    {
        $baseUrl = rtrim(base_url(), '/') . '/';

        return preg_replace(
            '~https?://(?:localhost|127\.0\.0\.1)(?::\d+)?/ggd-ci4/~i',
            $baseUrl,
            $content ?? '',
        ) ?? ($content ?? '');
    }
}

if (! function_exists('currencyConverterFunction')) {
    function currencyConverterFunction(mixed $productPrice): string
    {
        $session = service('session');
        $selectedCurrency = trim((string) $session->get('currency_code_session'));

        if ($selectedCurrency === '') {
            $session->set([
                'currency_code_session'   => 'AUD',
                'currency_country_code'   => 'AU',
                'currency_symbol_session' => '$',
                'currency_value_session'  => 1,
            ]);
        }

        if (! function_exists('percentageCalculator')) {
            function percentageCalculator(mixed $percentageAmount, mixed $totalPrice): float
            {
                if (! is_numeric($percentageAmount) || ! is_numeric($totalPrice)) {
                    return 0.0;
                }

                return round(((float) $percentageAmount / 100) * (float) $totalPrice, 2);
            }
        }

        $exchangeRate = $session->get('currency_value_session');
        $exchangeRate = is_numeric($exchangeRate) ? (float) $exchangeRate : 1.0;
        $symbol       = (string) ($session->get('currency_symbol_session') ?? '$');
        $price        = is_numeric($productPrice) ? (float) $productPrice : 0.0;

        return $symbol . round($price * $exchangeRate, 2);
    }
}

if (! function_exists('set_value')) {
    function set_value(string $field, mixed $default = ''): string
    {
        $value = service('request')->getPost($field);

        return esc((string) ($value ?? $default));
    }
}

if (! function_exists('form_error')) {
    function form_error(string $field): string
    {
        return esc((string) (service('validation')->getError($field) ?? ''));
    }
}

if (! function_exists('validation_errors')) {
    function validation_errors(): string
    {
        return service('validation')->listErrors();
    }
}
