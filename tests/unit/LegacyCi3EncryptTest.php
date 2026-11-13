<?php

use App\Libraries\LegacyCi3Encrypt;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LegacyCi3EncryptTest extends CIUnitTestCase
{
    public function testDecodesExistingCi3XorCiphertext(): void
    {
        $encrypt = new LegacyCi3Encrypt('unit-test-key');

        $this->assertSame('cart-123', $encrypt->decode('UDZUNgN3VHVTKwUzCDIKaA=='));
    }

    public function testEncodesAndDecodesNewRecoveryLinkValues(): void
    {
        $encrypt = new LegacyCi3Encrypt('unit-test-key');
        $encoded = $encrypt->encode('12345');

        $this->assertSame('12345', $encrypt->decode($encoded));
    }

    public function testRejectsMalformedCiphertext(): void
    {
        $this->assertNull((new LegacyCi3Encrypt('unit-test-key'))->decode('invalid!token'));
    }
}
