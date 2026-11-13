<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;

final class BackendCouponModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @return list<object>
     */
    public function discountEmailList(): array
    {
        return $this->db()->table('tbl_discount_email_list')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();
    }

    public function deleteDiscountEmail(int $id): bool
    {
        return $this->db()->table('tbl_discount_email_list')
            ->where('id', $id)
            ->delete();
    }

    /**
     * @return list<object>
     */
    public function coupons(): array
    {
        return $this->db()->table('tbl_coupon')
            ->where('coupon_delete_status', '0')
            ->orderBy('coupon_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function coupon(int $couponId): ?object
    {
        $row = $this->db()->table('tbl_coupon')
            ->where('coupon_id', $couponId)
            ->where('coupon_delete_status', '0')
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function addCoupon(array $coupon): bool
    {
        return $this->db()->table('tbl_coupon')->insert($coupon);
    }

    public function updateCoupon(int $couponId, array $coupon): bool
    {
        return $this->db()->table('tbl_coupon')
            ->where('coupon_id', $couponId)
            ->update($coupon);
    }

    public function deleteCoupon(int $couponId, int $userId, string $deletedAt): bool
    {
        return $this->db()->table('tbl_coupon')
            ->where('coupon_id', $couponId)
            ->update([
                'coupon_deleted_by' => $userId,
                'coupon_delete_status' => '1',
                'deleted_at' => $deletedAt,
            ]);
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
