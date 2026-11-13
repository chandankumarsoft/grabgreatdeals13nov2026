<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;
use RuntimeException;

final class BackendOrderModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @param array<string, string> $filters
     * @return list<object>
     */
    public function orders(array $filters = []): array
    {
        $builder = $this->db()->table('tbl_order ODR')
            ->select('ODR.order_id, ODR.order_no, ODR.invoice_no, ODR.order_amount, ODR.order_amount_withcurrency, ODR.coupon_amount_withorder, ODR.coupon_name, ODR.coupon_price, ODR.shipping_charge_with_currency, ODR.curreny_code, ODR.createdon, ODR.viewed_details, ODR.tracking_number_status, ODR.status AS order_status, CU.cus_name, CU.cus_mobile, PA.payment_status AS payment_status, PA.payment_type, bl.bill_name, bl.bill_email, bl.bill_mobile')
            ->join('tbl_customer CU', 'CU.cus_id = ODR.cus_id')
            ->join('tbl_payment PA', 'PA.payment_id = ODR.payment_id')
            ->join('tbl_billing bl', 'ODR.order_id = bl.order_id');

        foreach ([
            'payment_status' => 'PA.payment_status',
            'payment_type' => 'PA.payment_type',
            'view_status' => 'ODR.viewed_details',
            'tracking_status' => 'ODR.tracking_number_status',
            'currency' => 'ODR.curreny_code',
        ] as $filter => $column) {
            if (($filters[$filter] ?? '') !== '') {
                $builder->where($column, $filters[$filter]);
            }
        }

        return $builder->orderBy('ODR.order_id', 'DESC')->get()->getResult();
    }

    public function order(int $orderId): ?object
    {
        $row = $this->db()->table('tbl_order')
            ->where('order_id', $orderId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function billing(int $orderId): ?object
    {
        $row = $this->db()->table('tbl_billing B')
            ->select('B.*, C.country AS country_name, R.region AS state_name')
            ->join('country C', 'B.bill_country = C.id')
            ->join('region R', 'B.bill_state = R.id')
            ->where('B.order_id', $orderId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function shipping(int $orderId): ?object
    {
        $row = $this->db()->table('tbl_shipping S')
            ->select('S.*, C.country AS country_name, R.region AS state_name')
            ->join('country C', 'S.ship_country = C.id')
            ->join('region R', 'S.ship_state = R.id')
            ->where('S.order_id', $orderId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @return list<object>
     */
    public function orderDetails(int $orderId): array
    {
        return $this->db()->table('tbl_order_details TOD')
            ->select('TOD.*, C.color AS color_name, S.size_name AS size_name')
            ->join('tbl_color C', 'TOD.product_color = C.color_id', 'LEFT')
            ->join('tbl_size S', 'TOD.product_size = S.size_id', 'LEFT')
            ->where('TOD.order_id', $orderId)
            ->get()
            ->getResult();
    }

    public function markViewed(int $orderId): bool
    {
        return $this->db()->table('tbl_order')
            ->where('order_id', $orderId)
            ->update(['viewed_details' => 1]);
    }

    public function deleteOrder(int $orderId, int $shippingId, int $paymentId): void
    {
        $database = $this->db();
        $database->transBegin();

        try {
            foreach ([
                ['tbl_order_details', 'order_id', $orderId],
                ['tbl_shipping', 'shipping_id', $shippingId],
                ['tbl_payment', 'payment_id', $paymentId],
                ['tbl_order', 'order_id', $orderId],
            ] as [$table, $column, $value]) {
                if (! $database->table($table)->where($column, $value)->delete()) {
                    throw new RuntimeException('Unable to delete order details.');
                }
            }
            $database->transCommit();
            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to delete the order.');
            }
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
