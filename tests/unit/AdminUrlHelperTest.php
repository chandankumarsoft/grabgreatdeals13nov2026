<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class AdminUrlHelperTest extends CIUnitTestCase
{
    public function testPrefixesPathsWithTheAdminRoute(): void
    {
        helper(['url', 'legacy_storefront']);

        $this->assertSame(base_url('admin/product-list'), admin_url('product-list'));
        $this->assertSame(
            base_url('admin/search_by_product_name?name=chair'),
            admin_url('/search_by_product_name?name=chair'),
        );
        $this->assertSame(base_url('admin'), admin_url());
    }
}
