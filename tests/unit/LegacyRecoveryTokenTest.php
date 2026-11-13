<?php

use App\Libraries\LegacyRecoveryToken;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LegacyRecoveryTokenTest extends CIUnitTestCase
{
    public function testRoundTripsPurposeBoundValues(): void
    {
        $tokens = new LegacyRecoveryToken(str_repeat('k', 32));
        $token = $tokens->encode('password_reset', 'user@example.test', 600);

        $this->assertIsString($token);
        $this->assertSame('user@example.test', $tokens->decode($token, 'password_reset'));
        $this->assertNull($tokens->decode($token, 'cart_id'));
    }

    public function testRejectsChangedSignature(): void
    {
        $tokens = new LegacyRecoveryToken(str_repeat('k', 32));
        $token = $tokens->encode('cart_id', 123, 600);

        $this->assertIsString($token);
        $this->assertNull($tokens->decode($token . 'x', 'cart_id'));
    }

    public function testDoesNotIssueTokensWithoutStrongSigningKey(): void
    {
        $this->assertNull((new LegacyRecoveryToken('short'))->encode('user_id', 10, 600));
    }
}
