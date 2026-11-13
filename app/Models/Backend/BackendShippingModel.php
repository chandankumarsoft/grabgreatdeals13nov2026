<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;
use RuntimeException;

final class BackendShippingModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @return list<object>
     */
    public function charges(): array
    {
        return $this->db()->table('tbl_shipping_charge')
            ->where('shipping_delete_status', '0')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();
    }

    public function charge(int $chargeId): ?object
    {
        $row = $this->db()->table('tbl_shipping_charge')
            ->where('id', $chargeId)
            ->where('shipping_delete_status', '0')
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function addCharge(array $charge): bool
    {
        return $this->db()->table('tbl_shipping_charge')->insert($charge);
    }

    public function updateCharge(int $chargeId, array $charge): bool
    {
        return $this->db()->table('tbl_shipping_charge')
            ->where('id', $chargeId)
            ->update($charge);
    }

    public function deleteCharge(int $chargeId, int $userId, string $deletedAt): bool
    {
        return $this->db()->table('tbl_shipping_charge')
            ->where('id', $chargeId)
            ->update([
                'deleted_by' => $userId,
                'shipping_delete_status' => '1',
                'deleted_at' => $deletedAt,
            ]);
    }

    /**
     * @return list<object>
     */
    public function products(): array
    {
        return $this->db()->table('tbl_product')
            ->select('pro_id, pro_title')
            ->orderBy('pro_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function product(int $productId): ?object
    {
        $row = $this->db()->table('tbl_product')
            ->select('pro_id, pro_title')
            ->where('pro_id', $productId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @return list<object>
     */
    public function productChargeList(): array
    {
        return $this->db()->table('tbl_shipping_charge_relation TSR')
            ->select('TSR.pro_id, GROUP_CONCAT(TSR.ship_charge_id) AS ship_charge_id, MAX(TSR.created_at) AS created_at, MAX(TP.pro_title) AS pro_title, GROUP_CONCAT(DISTINCT TSC.shipping_description SEPARATOR \', \') AS shipping_description', false)
            ->join('tbl_product TP', 'TSR.pro_id = TP.pro_id', 'LEFT')
            ->join('tbl_shipping_charge TSC', 'TSR.ship_charge_id = TSC.id', 'LEFT')
            ->groupBy('TSR.pro_id')
            ->orderBy('GROUP_CONCAT(TSR.ship_charge_id)', 'DESC', false)
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function productCharges(int $productId): array
    {
        return $this->db()->table('tbl_shipping_charge_relation')
            ->select('ship_charge_id')
            ->where('pro_id', $productId)
            ->get()
            ->getResult();
    }

    /**
     * @param list<int> $chargeIds
     * @param list<int> $productIds
     */
    public function addProductCharges(array $chargeIds, array $productIds, int $userId): void
    {
        $database = $this->db();
        $database->transBegin();

        try {
            foreach ($productIds as $productId) {
                foreach ($chargeIds as $chargeId) {
                    $exists = $database->table('tbl_shipping_charge_relation')
                        ->where('pro_id', $productId)
                        ->where('ship_charge_id', $chargeId)
                        ->countAllResults();
                    if ($exists > 0) {
                        continue;
                    }

                    $this->insertRelation($productId, $chargeId, $userId);
                }
            }
            $database->transCommit();
            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to save product shipping charges.');
            }
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    /**
     * @param list<int> $chargeIds
     * @param list<int> $productIds
     */
    public function replaceProductCharges(array $chargeIds, array $productIds, int $userId): void
    {
        $database = $this->db();
        $database->transBegin();

        try {
            foreach ($productIds as $productId) {
                if (! $database->table('tbl_shipping_charge_relation')->where('pro_id', $productId)->delete()) {
                    throw new RuntimeException('Unable to replace product shipping charges.');
                }
                foreach ($chargeIds as $chargeId) {
                    $this->insertRelation($productId, $chargeId, $userId);
                }
            }
            $database->transCommit();
            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to save product shipping charges.');
            }
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    public function deleteProductCharges(int $productId): bool
    {
        return $this->db()->table('tbl_shipping_charge_relation')
            ->where('pro_id', $productId)
            ->delete();
    }

    private function insertRelation(int $productId, int $chargeId, int $userId): void
    {
        if (! $this->db()->table('tbl_shipping_charge_relation')->insert([
            'pro_id' => $productId,
            'ship_charge_id' => $chargeId,
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $userId,
        ])) {
            throw new RuntimeException('Unable to save product shipping charges.');
        }
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
