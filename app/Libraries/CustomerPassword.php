<?php

namespace App\Libraries;

final class CustomerPassword
{
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verify(string $password, string $storedPassword): bool
    {
        if (password_get_info($storedPassword)['algoName'] !== 'unknown') {
            return password_verify($password, $storedPassword);
        }

        return hash_equals($storedPassword, $password);
    }

    public static function needsRehash(string $storedPassword): bool
    {
        return password_get_info($storedPassword)['algoName'] === 'unknown'
            || password_needs_rehash($storedPassword, PASSWORD_DEFAULT);
    }
}
