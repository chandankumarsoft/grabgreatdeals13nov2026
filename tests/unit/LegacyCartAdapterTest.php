<?php

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacySessionAdapter;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LegacyCartAdapterTest extends CIUnitTestCase
{
    public function testInsertUpdateAndRemoveCartItemsInLegacySessionFormat(): void
    {
        $session = service('session');
        $session->remove('cart_contents');
        $cart = new LegacyCartAdapter(new LegacySessionAdapter($session));
        $item = [
            'id'      => 17,
            'qty'     => 2,
            'price'   => 3.5,
            'name'    => 'Test product',
            'options' => ['pro_image' => 'product.jpg'],
        ];

        $rowId = $cart->insert($item);

        $this->assertIsString($rowId);
        $this->assertSame(2, $cart->total_items());
        $this->assertSame(7.0, $cart->total());

        $item['qty'] = 1;
        $cart->insert($item);
        $this->assertSame(3, $cart->total_items());
        $this->assertSame(10.5, $cart->total());

        $this->assertTrue($cart->update(['rowid' => $rowId, 'shipping_method' => '4']));
        $this->assertSame('4', $cart->contents()[0]['shipping_method']);

        $this->assertTrue($cart->update(['rowid' => $rowId, 'qty' => 0]));
        $this->assertSame([], $cart->contents());
        $this->assertSame(0, $cart->total_items());
        $session->remove('cart_contents');
    }

    public function testRejectsInvalidCartItemsAndUpdates(): void
    {
        $session = service('session');
        $session->remove('cart_contents');
        $cart = new LegacyCartAdapter(new LegacySessionAdapter($session));

        $this->assertFalse($cart->insert([
            'id'      => 17,
            'qty'     => 0,
            'price'   => 3.5,
            'name'    => 'Test product',
            'options' => [],
        ]));
        $this->assertFalse($cart->update(['rowid' => 'missing', 'qty' => 1]));
        $this->assertSame([], $cart->contents());
    }
}
