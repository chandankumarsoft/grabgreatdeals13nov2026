<?php

use App\Libraries\CustomerPassword;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class CustomerPasswordTest extends CIUnitTestCase
{
    public function testHashesAndVerifiesPasswords(): void
    {
        $hash = CustomerPassword::hash('correct horse battery staple');

        $this->assertNotSame('correct horse battery staple', $hash);
        $this->assertTrue(CustomerPassword::verify('correct horse battery staple', $hash));
        $this->assertFalse(CustomerPassword::verify('incorrect password', $hash));
        $this->assertFalse(CustomerPassword::needsRehash($hash));
    }

    public function testVerifiesLegacyPlaintextPasswordsForLoginUpgrade(): void
    {
        $this->assertTrue(CustomerPassword::verify('legacy-password', 'legacy-password'));
        $this->assertFalse(CustomerPassword::verify('incorrect-password', 'legacy-password'));
        $this->assertTrue(CustomerPassword::needsRehash('legacy-password'));
    }
}
