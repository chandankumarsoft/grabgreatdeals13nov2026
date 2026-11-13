<?php

namespace App\Models;

use CodeIgniter\Database\BaseConnection;

final class LegacyProfileModel
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = db_connect();
    }

    /**
     * @return list<object>
     */
    public function get_all_order(int|string $customerId): array
    {
        return $this->database->table('tbl_order O')
            ->select('O.*, S.ship_name, S.ship_address')
            ->join('tbl_shipping S', 'O.ship_id = S.ship_id', 'left')
            ->where('O.cus_id', $customerId)
            ->orderBy('O.createdon', 'DESC')
            ->get()
            ->getResult();
    }

    public function get_all_order_order_id(int|string $customerId, int|string $orderId): ?object
    {
        return $this->database->table('tbl_order O')
            ->select('O.*, S.ship_name, S.ship_address')
            ->join('tbl_shipping S', 'O.ship_id = S.ship_id', 'left')
            ->where('O.cus_id', $customerId)
            ->where('O.order_id', $orderId)
            ->get()
            ->getRow();
    }

    public function get_billing_details_order_by_id(int|string $customerId, int|string $orderId): ?object
    {
        return $this->database->table('tbl_billing B')
            ->select('B.*, C.country AS country_name, R.region AS state_name')
            ->join('country C', 'B.bill_country = C.id', 'left')
            ->join('region R', 'B.bill_state = R.id', 'left')
            ->where('B.cus_id', $customerId)
            ->where('B.order_id', $orderId)
            ->get()
            ->getRow();
    }

    public function get_shipping_details_order_by_id(int|string $customerId, int|string $orderId): ?object
    {
        return $this->database->table('tbl_shipping S')
            ->select('S.*, C.country AS country_name, R.region AS state_name')
            ->join('country C', 'S.ship_country = C.id', 'left')
            ->join('region R', 'S.ship_state = R.id', 'left')
            ->where('S.cus_id', $customerId)
            ->where('S.order_id', $orderId)
            ->get()
            ->getRow();
    }

    /**
     * @return list<object>
     */
    public function get_order_details(int|string $orderId): array
    {
        return $this->database->table('tbl_order_details D')
            ->select('P.pro_title, P.pro_title_slug, P.pro_image, D.*, C.color AS product_color, Z.size_name AS product_size')
            ->join('tbl_product P', 'P.pro_id = D.product_id', 'left')
            ->join('tbl_color C', 'C.color_id = D.product_color', 'left')
            ->join('tbl_size Z', 'Z.size_id = D.product_size', 'left')
            ->where('D.order_id', $orderId)
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function get_wishlist(int|string $customerId): array
    {
        return $this->database->table('tbl_wishlist W')
            ->select('W.*, P.pro_id, P.pro_title, P.pro_title_slug, P.pro_image, P.pro_price, P.pro_offer_price')
            ->join('tbl_product P', 'W.wishlist_pro_id = P.pro_id', 'inner')
            ->where('W.wishlist_cus_id', $customerId)
            ->get()
            ->getResult();
    }
}
