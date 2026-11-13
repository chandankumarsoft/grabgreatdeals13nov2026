<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyCi3Encrypt;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacyRecoveryToken;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Cart extends BaseController
{
    public function ReturnCart(): ResponseInterface
    {
        $cartToken = $this->request->getGet('cart_id');
        $userToken = $this->request->getGet('dis_id');
        if (! is_string($cartToken) || $cartToken === '' || ! is_string($userToken) || $userToken === '') {
            return $this->response->setStatusCode(400)->setBody('The cart recovery link is invalid.');
        }

        $tokens = new LegacyRecoveryToken();
        $cartId = $tokens->decode($cartToken, 'cart_id');
        $userId = $tokens->decode($userToken, 'user_id');

        if ($cartId === null || $userId === null) {
            if (
                (is_string($cartToken) && str_starts_with($cartToken, 'v2.'))
                || (is_string($userToken) && str_starts_with($userToken, 'v2.'))
            ) {
                return $this->response->setStatusCode(400)->setBody('The cart recovery link is invalid or expired.');
            }

            try {
                $encrypt = new LegacyCi3Encrypt();
                $cartId = $encrypt->decode($cartToken);
                $userId = $encrypt->decode($userToken);
            } catch (RuntimeException $exception) {
                log_message('error', 'Cart recovery is unavailable: {message}', [
                    'message' => $exception->getMessage(),
                ]);

                return $this->response->setStatusCode(503)->setBody('Cart recovery is temporarily unavailable.');
            }
        }

        if ($cartId === null || $userId === null || ! ctype_digit($cartId) || ! ctype_digit($userId)) {
            return $this->response->setStatusCode(400)->setBody('The cart recovery link is invalid.');
        }

        $rows = db_connect()->table('tbl_cartformail')
            ->where('cart_id', $cartId)
            ->where('user_id', $userId)
            ->get()
            ->getResult();
        if ($rows === []) {
            return $this->response->setStatusCode(404)->setBody('The saved cart was not found.');
        }

        $productModel = new LegacyProductModel();
        $cart = $this->cartAdapter();
        $restored = 0;
        foreach ($rows as $row) {
            $product = $productModel->getProductById($row->cart_pro_id);
            if ($product === null || ! is_numeric($row->cart_qty) || (int) $row->cart_qty < 1
                || ! is_numeric($row->cart_price) || (float) $row->cart_price < 0) {
                log_message('warning', 'Skipped invalid item in saved cart {cartId}.', ['cartId' => $cartId]);
                continue;
            }

            if ($cart->insert([
                'id'               => $product->pro_id,
                'qty'              => (int) $row->cart_qty,
                'price'            => (float) $row->cart_price,
                'name'             => $product->pro_title,
                'pro_title_slug'   => $product->pro_title_slug,
                'shipping_method'  => (string) $row->cart_shipping_method,
                'options'          => [
                    'pro_image'     => $product->pro_image,
                    'product_color' => (string) $row->cart_product_color,
                    'product_size'  => (string) $row->cart_product_size,
                    'product_sku'   => (string) ($product->product_sku_name ?? ''),
                ],
            ]) !== false) {
                $restored++;
            }
        }

        if ($restored === 0) {
            return $this->response->setStatusCode(410)->setBody('The saved cart no longer contains available products.');
        }

        return redirect()->to(site_url('show-cart'));
    }

    public function add_to_cart(): ResponseInterface
    {
        $product = $this->getPostedProduct();
        if ($product instanceof ResponseInterface) {
            return $product;
        }

        $price = (float) $product->pro_price;
        if ((float) $product->pro_offer_price > 0) {
            $price = (float) $product->pro_offer_price;
        }

        $inserted = $this->cartAdapter()->insert([
            'id'             => $product->pro_id,
            'qty'            => $this->request->getPost('qty'),
            'price'          => $price,
            'name'           => $product->pro_title,
            'pro_title_slug' => $product->pro_title_slug,
            'shipping_method' => $this->getDefaultShippingMethod($product->pro_id),
            'options'        => ['pro_image' => $product->pro_image],
        ]);

        if ($inserted === false) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid cart quantity.']);
        }

        return $this->response->setJSON(['success' => 1]);
    }

    public function add_to_cart_details(): ResponseInterface
    {
        $product = $this->getPostedProduct();
        if ($product instanceof ResponseInterface) {
            return $product;
        }

        $colorId = (string) $this->request->getPost('product_color');
        $sizeId = (string) $this->request->getPost('product_size');
        $shippingMethod = (string) $this->request->getPost('shipping_method');
        if ($shippingMethod === '') {
            $shippingMethod = $this->getDefaultShippingMethod($product->pro_id);
        }

        if ($shippingMethod !== '' && ! $this->shippingMethodIsValid($product->pro_id, $shippingMethod)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid shipping method.']);
        }

        $price = $this->request->getPost('product_price_to_cart');
        $expectedPrice = $this->getVariantPrice($product, $colorId, $sizeId);
        if (
            $expectedPrice === null
            || ! is_numeric($price)
            || (float) $price !== $expectedPrice
        ) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid product price.']);
        }

        $inserted = $this->cartAdapter()->insert([
            'id'               => $product->pro_id,
            'qty'              => $this->request->getPost('qty'),
            'price'            => $expectedPrice,
            'name'             => $product->pro_title,
            'pro_title_slug'   => $product->pro_title_slug,
            'shipping_method'  => $shippingMethod,
            'options'          => [
                'pro_image'     => $product->pro_image,
                'product_color' => $colorId,
                'product_size'  => $sizeId,
                'product_sku'   => (string) ($product->product_sku_name ?? ''),
            ],
        ]);

        if ($inserted === false) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid cart quantity.']);
        }

        $session = service('session');
        if ($session->get('cus_email') && $session->get('cus_id')) {
            $this->saveCartForReturnEmail();
        }

        return $this->response->setJSON(['success' => 'ok']);
    }

    public function delete_to_cart(string $rowId): ResponseInterface
    {
        if (! $this->cartAdapter()->update(['rowid' => $rowId, 'qty' => 0])) {
            return $this->response->setStatusCode(404)->setBody('Cart item not found.');
        }

        return redirect()->to(site_url('show-cart'));
    }

    public function delete_to_cart_header(string $rowId): ResponseInterface
    {
        if (! $this->cartAdapter()->update(['rowid' => $rowId, 'qty' => 0])) {
            return $this->response->setStatusCode(404)->setBody('Cart item not found.');
        }

        return redirect()->to(base_url());
    }

    public function update_cart_quantity(): ResponseInterface
    {
        if (! $this->cartAdapter()->update([
            'rowid' => (string) $this->request->getPost('rowid'),
            'qty'   => $this->request->getPost('qty'),
        ])) {
            return $this->response->setStatusCode(400)->setBody('Invalid cart item or quantity.');
        }

        return redirect()->to(site_url('show-cart'));
    }

    public function update_cart_quantity_payment(): ResponseInterface
    {
        if (! $this->cartAdapter()->update([
            'rowid' => (string) $this->request->getPost('rowid'),
            'qty'   => $this->request->getPost('qty'),
        ])) {
            return $this->response->setStatusCode(400)->setBody('Invalid cart item or quantity.');
        }

        return redirect()->to(site_url('payment'));
    }

    public function update_cart_shipping_method(): ResponseInterface
    {
        $rowId = (string) $this->request->getPost('rowid');
        $shippingMethod = (string) $this->request->getPost('shipping_method');
        $item = null;
        foreach ($this->cartAdapter()->contents() as $cartItem) {
            if (($cartItem['rowid'] ?? '') === $rowId) {
                $item = $cartItem;
                break;
            }
        }

        if ($item === null || ! ctype_digit($shippingMethod)) {
            return $this->response->setStatusCode(404)->setJSON(['error_msg' => 'Cart item or shipping method not found.']);
        }

        $shippingMethodExists = db_connect()->table('tbl_shipping_charge_relation TSCR')
            ->join('tbl_shipping_charge TSC', 'TSC.id = TSCR.ship_charge_id', 'inner')
            ->where('TSCR.pro_id', $item['id'])
            ->where('TSC.id', $shippingMethod)
            ->countAllResults();

        if ($shippingMethodExists === 0) {
            return $this->response->setStatusCode(404)->setJSON(['error_msg' => 'Cart item or shipping method not found.']);
        }

        $updated = $this->cartAdapter()->update([
            'rowid'           => $rowId,
            'shipping_method' => $shippingMethod,
        ]);

        if (! $updated) {
            return $this->response->setStatusCode(404)->setJSON(['error_msg' => 'Cart item not found.']);
        }

        return $this->response->setJSON(['error_msg' => 'success']);
    }

    public function delete_to_cart_payment(string $rowId): ResponseInterface
    {
        if (! $this->cartAdapter()->update(['rowid' => $rowId, 'qty' => 0])) {
            return $this->response->setStatusCode(404)->setBody('Cart item not found.');
        }

        return redirect()->to(site_url('payment'));
    }

    public function get_color_data(): ResponseInterface
    {
        $database = db_connect();
        $selected = $database->table('tbl_attr_relation_color')
            ->where('attr_color_relation_id', $this->request->getPost('thiscolorvalue'))
            ->get()
            ->getRow();

        if ($selected === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product color not found.']);
        }

        $color = $database->table('tbl_color')
            ->select('color')
            ->where('color_id', $selected->attr_relation_color_name)
            ->get()
            ->getRow();

        if ($color === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Color not found.']);
        }

        $regularPrice = max(
            (float) $selected->attr_relation_color_regular_price,
            $this->numericPost('regularnewsizeprice'),
        );
        $salePrice = max(
            (float) $selected->attr_relation_color_sale_price,
            $this->numericPost('specialnewsizeprice'),
        );

        helper('legacy_storefront');

        return $this->response->setJSON([
            'attr_relation_color_name'          => $color->color,
            'attr_relation_color_code'          => $selected->attr_relation_color_name,
            'attr_relation_color_image'         => $selected->attr_relation_color_image,
            'attr_relation_color_regular_price' => $selected->attr_relation_color_regular_price,
            'attr_relation_color_sale_price'    => $selected->attr_relation_color_sale_price,
            'attr_relation_color_quantity'      => $selected->attr_relation_color_quantity,
            'final_regular_price'               => $regularPrice,
            'final_sale_price'                  => $salePrice,
            'final_regular_price_show'          => currencyConverterFunction($regularPrice),
            'final_sale_price_show'             => currencyConverterFunction($salePrice),
        ]);
    }

    public function get_attribute_images(): ResponseInterface
    {
        $productId = $this->request->getPost('colorProductId');
        $colorId   = $this->request->getPost('colorId');

        if (
            ! is_scalar($productId)
            || ! ctype_digit((string) $productId)
            || (int) $productId < 1
            || ! is_scalar($colorId)
            || ! ctype_digit((string) $colorId)
            || (int) $colorId < 1
        ) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid product color.']);
        }

        $images = (new LegacyProductModel())->getAttributeImagesForColor(
            (int) $productId,
            (int) $colorId,
        );

        return $this->response->setJSON($images);
    }

    public function get_size_data(): ResponseInterface
    {
        $selected = db_connect()->table('tbl_attr_relation_size')
            ->where('attr_size_relation_id', $this->request->getPost('thissizevalue'))
            ->get()
            ->getRow();

        if ($selected === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product size not found.']);
        }

        $regularPrice = max(
            (float) $selected->attr_relation_size_regular_price,
            $this->numericPost('regularnewcolorprice'),
        );
        $salePrice = max(
            (float) $selected->attr_relation_size_sale_price,
            $this->numericPost('specialnewcolorprice'),
        );

        helper('legacy_storefront');

        return $this->response->setJSON([
            'attr_relation_size_regular_price' => $selected->attr_relation_size_regular_price,
            'attr_relation_size_sale_price'    => $selected->attr_relation_size_sale_price,
            'attr_relation_size_quantity'      => $selected->attr_relation_size_quantity,
            'attr_relation_size_code'          => $selected->attr_relation_size_name,
            'final_regular_price'              => $regularPrice,
            'final_sale_price'                 => $salePrice,
            'final_regular_price_show'         => currencyConverterFunction($regularPrice),
            'final_sale_price_show'            => currencyConverterFunction($salePrice),
        ]);
    }

    public function cartCouponDiscount(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules(['cartcoupondiscount' => 'required']);

        if (! $validation->run($this->request->getPost())) {
            return $this->response->setJSON([
                'error_msg_validation' => '<p>' . esc($validation->getError('cartcoupondiscount')) . '</p>',
            ]);
        }

        $coupon = db_connect()->table('tbl_coupon')
            ->where('coupon_name', $this->request->getPost('cartcoupondiscount'))
            ->get()
            ->getRow();

        if ($coupon === null || $coupon->coupon_type !== 'percentage') {
            return $this->response->setJSON(['error_msg_validation' => 'coupon is not exists']);
        }

        service('session')->set([
            'couponprice' => $coupon->coupon_amount,
            'couponname'  => $coupon->coupon_name,
        ]);

        return $this->response->setJSON(['error_msg' => 'success']);
    }

    public function show_cart(): string
    {
        helper('legacy_storefront');

        $session = new LegacySessionAdapter(service('session'));
        $renderer = new LegacyViewRenderer('frontend', [
            'session' => $session,
            'uri'     => new LegacyUriAdapter(service('uri')),
            'cart'    => new LegacyCartAdapter($session),
            'db'      => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ]);
        $output = '';

        foreach ([
            ['front/header', ['page' => 'add_to_cart_page']],
            ['front/category', []],
            ['front/shopping_cart', []],
            ['front/footer', []],
        ] as [$view, $data]) {
            $output .= $renderer->render($view, $data);
        }

        return $output;
    }

    private function getPostedProduct(): \stdClass|ResponseInterface
    {
        $productId = $this->request->getPost('pro_id');
        if (! is_scalar($productId) || ! ctype_digit((string) $productId)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid product.']);
        }

        $product = (new LegacyProductModel())->getProductById((string) $productId);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product not found.']);
        }

        return $product;
    }

    private function getVariantPrice(object $product, string $colorId, string $sizeId): ?float
    {
        $price = (float) $product->pro_price;
        if ((float) $product->pro_offer_price > 0) {
            $price = (float) $product->pro_offer_price;
        }

        $database = db_connect();
        foreach ([
            [
                'table'       => 'tbl_attr_relation_color',
                'product_key' => 'attr_color_relation_product_id',
                'value_key'   => 'attr_relation_color_name',
                'price_key'   => 'attr_relation_color_sale_price',
                'value'       => $colorId,
            ],
            [
                'table'       => 'tbl_attr_relation_size',
                'product_key' => 'attr_size_relation_product_id',
                'value_key'   => 'attr_relation_size_name',
                'price_key'   => 'attr_relation_size_sale_price',
                'value'       => $sizeId,
            ],
        ] as $variant) {
            if ($variant['value'] === '') {
                continue;
            }

            if (! ctype_digit($variant['value'])) {
                return null;
            }

            $record = $database->table($variant['table'])
                ->where($variant['product_key'], $product->pro_id)
                ->where($variant['value_key'], $variant['value'])
                ->get()
                ->getRow();

            if ($record === null) {
                return null;
            }

            $price = max($price, (float) $record->{$variant['price_key']});
        }

        return $price;
    }

    private function getDefaultShippingMethod(int|string $productId): string
    {
        $shipping = db_connect()->table('tbl_shipping_charge_relation')
            ->select('ship_charge_id')
            ->where('pro_id', $productId)
            ->orderBy('ship_charge_id', 'ASC')
            ->get()
            ->getRow();

        return $shipping === null ? '' : (string) $shipping->ship_charge_id;
    }

    private function shippingMethodIsValid(int|string $productId, string $shippingMethod): bool
    {
        if (! ctype_digit($shippingMethod)) {
            return false;
        }

        return db_connect()->table('tbl_shipping_charge_relation TSCR')
            ->join('tbl_shipping_charge TSC', 'TSC.id = TSCR.ship_charge_id', 'inner')
            ->where('TSCR.pro_id', $productId)
            ->where('TSC.id', $shippingMethod)
            ->countAllResults() > 0;
    }

    private function cartAdapter(): LegacyCartAdapter
    {
        return new LegacyCartAdapter(new LegacySessionAdapter(service('session')));
    }

    private function numericPost(string $key): float
    {
        $value = $this->request->getPost($key);

        return is_numeric($value) ? (float) $value : 0.0;
    }

    private function saveCartForReturnEmail(): void
    {
        $session = service('session');
        $cartId = $session->get('cartTimeCheck');

        if ($cartId === null || $cartId === '') {
            $cartId = time();
            $session->set('cartTimeCheck', $cartId);
        }

        $userId = $session->get('cus_id');
        $database = db_connect();
        $database->table('tbl_cartformail')
            ->where('user_id', $userId)
            ->where('cart_id', $cartId)
            ->delete();

        foreach ($this->cartAdapter()->contents() as $item) {
            $row = [
                'user_id'              => $userId,
                'user_email'           => $session->get('cus_email'),
                'user_name'            => $session->get('cus_name'),
                'currency_code'        => $session->get('currency_code_session'),
                'country_code'         => $session->get('currency_country_code'),
                'cart_id'              => $cartId,
                'cart_session_id'      => $item['rowid'],
                'cart_pro_id'          => $item['id'],
                'cart_qty'             => $item['qty'],
                'cart_price'           => $item['price'],
                'cart_name'            => $item['name'],
                'cart_pro_title_slug'  => $item['pro_title_slug'] ?? '',
                'cart_shipping_method' => $item['shipping_method'] ?? '',
                'cart_pro_image'       => $item['options']['pro_image'] ?? '',
                'cart_product_color'   => $item['options']['product_color'] ?? '',
                'cart_product_size'    => $item['options']['product_size'] ?? '',
                'cart_product_sku'     => $item['options']['product_sku'] ?? '',
                'cart_row'             => $item['rowid'],
                'cart_subtotal'        => $item['subtotal'],
                'created_at'           => date('Y-m-d H:i:s'),
            ];

            if (! $database->table('tbl_cartformail')->insert($row)) {
                throw new RuntimeException('Unable to save the cart for email recovery.');
            }
        }
    }
}
