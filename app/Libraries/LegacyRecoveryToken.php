<?php

namespace App\Libraries;

final class LegacyRecoveryToken
{
    private readonly string $signingKey;

    public function __construct(?string $signingKey = null)
    {
        $this->signingKey = $signingKey ?? (string) env('legacy.recoverySigningKey', '');
    }

    public function encode(string $purpose, string|int $value, int $ttlSeconds): ?string
    {
        if (strlen($this->signingKey) < 32 || preg_match('/\A[a-z_]{1,32}\z/', $purpose) !== 1 || $ttlSeconds < 1) {
            return null;
        }

        $expiresAt = time() + $ttlSeconds;
        $payload = $this->base64UrlEncode((string) $value);
        $unsigned = 'v2.' . $purpose . '.' . $expiresAt . '.' . $payload;
        $signature = $this->base64UrlEncode(hash_hmac('sha256', $unsigned, $this->signingKey, true));

        return $unsigned . '.' . $signature;
    }

    public function decode(mixed $token, string $expectedPurpose): ?string
    {
        if (
            ! is_string($token)
            || strlen($this->signingKey) < 32
            || preg_match('/\Av2\.([a-z_]{1,32})\.([0-9]{1,12})\.([A-Za-z0-9_-]+)\.([A-Za-z0-9_-]+)\z/', $token, $matches) !== 1
            || $matches[1] !== $expectedPurpose
            || (int) $matches[2] < time()
        ) {
            return null;
        }

        $unsigned = 'v2.' . $matches[1] . '.' . $matches[2] . '.' . $matches[3];
        $expectedSignature = $this->base64UrlEncode(hash_hmac('sha256', $unsigned, $this->signingKey, true));
        if (! hash_equals($expectedSignature, $matches[4])) {
            return null;
        }

        return $this->base64UrlDecode($matches[3]);
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $value): ?string
    {
        $base64 = strtr($value, '-_', '+/');
        $decoded = base64_decode($base64 . str_repeat('=', (4 - strlen($base64) % 4) % 4), true);

        return $decoded === false ? null : $decoded;
    }
}
