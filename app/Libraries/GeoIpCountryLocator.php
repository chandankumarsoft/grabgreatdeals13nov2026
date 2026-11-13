<?php

namespace App\Libraries;

use MaxMind\Db\Reader;
use MaxMind\Db\Reader\InvalidDatabaseException;

final class GeoIpCountryLocator
{
    public function __construct(private readonly string $databasePath)
    {
    }

    public function countryCode(string $ipAddress): ?string
    {
        if (
            filter_var(
                $ipAddress,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            ) === false
        ) {
            return null;
        }

        $reader = null;

        try {
            $reader = new Reader($this->databasePath);
            $record = $reader->get($ipAddress);
        } catch (\InvalidArgumentException | \UnexpectedValueException | InvalidDatabaseException) {
            log_message('warning', 'GeoLite country lookup failed; the configured default currency will be used.');

            return null;
        } finally {
            if ($reader !== null) {
                $reader->close();
            }
        }

        $countryCode = $record['country']['iso_code'] ?? null;
        if (! is_string($countryCode) || preg_match('/\A[A-Z]{2}\z/i', $countryCode) !== 1) {
            return null;
        }

        return strtoupper($countryCode);
    }
}
