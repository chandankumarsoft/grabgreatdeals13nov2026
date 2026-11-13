<?php

use App\Libraries\LegacyPaginationAdapter;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LegacyPaginationAdapterTest extends CIUnitTestCase
{
    public function testCreatesPaginationLinksUsingLegacyOffsetValues(): void
    {
        $pagination = new LegacyPaginationAdapter('http://localhost/shop', 25, 10, 10);
        $links      = $pagination->create_links();

        $this->assertStringContainsString('page=0', $links);
        $this->assertStringContainsString('page=20', $links);
        $this->assertStringContainsString('<li class="active"><a href="#">2</a></li>', $links);
    }

    public function testDoesNotCreateLinksForSinglePageResults(): void
    {
        $pagination = new LegacyPaginationAdapter('http://localhost/shop', 10, 10, 0);

        $this->assertSame('', $pagination->create_links());
    }
}
