<?php

namespace App\Libraries;

use RuntimeException;

final class LegacyCi3Encrypt
{
    private readonly string $keyHash;

    public function __construct(?string $legacyKey = null)
    {
        $key = $legacyKey ?? (string) env('legacy.ci3EncryptionKey', '');
        if ($key === '') {
            throw new RuntimeException('The CI3 encryption key is not configured.');
        }

        $this->keyHash = sha1(md5($key));
    }

    public function encode(string|int $value): string
    {
        $value = (string) $value;
        $random = '';
        while (strlen($random) < 32) {
            $random .= (string) random_int(0, PHP_INT_MAX);
        }
        $randomHash = sha1($random);
        $combined = '';

        for ($i = 0, $length = strlen($value); $i < $length; $i++) {
            $noise = $randomHash[$i % strlen($randomHash)];
            $combined .= $noise . ($noise ^ $value[$i]);
        }

        return base64_encode($this->xorMerge($combined));
    }

    public function decode(mixed $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        $value = str_replace(' ', '+', $value);
        if (preg_match('/\A[A-Za-z0-9\/+=]+\z/', $value) !== 1) {
            return null;
        }

        $decoded = base64_decode($value, true);
        if ($decoded === false) {
            return null;
        }

        $combined = $this->xorMerge($decoded);
        $result = '';
        for ($i = 0, $length = strlen($combined); $i < $length; $i += 2) {
            if (! isset($combined[$i + 1])) {
                return null;
            }
            $result .= $combined[$i] ^ $combined[$i + 1];
        }

        return $result;
    }

    private function xorMerge(string $value): string
    {
        $result = '';
        $hashLength = strlen($this->keyHash);

        for ($i = 0, $length = strlen($value); $i < $length; $i++) {
            $result .= $value[$i] ^ $this->keyHash[$i % $hashLength];
        }

        return $result;
    }
}
