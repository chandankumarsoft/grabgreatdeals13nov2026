<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;

final class BackendBrandModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    public function all(): array
    {
        return $this->db()->table('tbl_brand')
            ->orderBy('brand_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function find(int $brandId): ?object
    {
        $brand = $this->db()->table('tbl_brand')
            ->where('brand_id', $brandId)
            ->get()
            ->getRow();

        return $brand === null ? null : (object) $brand;
    }

    public function create(string $name): bool
    {
        return $this->db()->table('tbl_brand')->insert(['brand_name' => $name]);
    }

    public function update(int $brandId, string $name): bool
    {
        return $this->db()->table('tbl_brand')
            ->where('brand_id', $brandId)
            ->update(['brand_name' => $name]);
    }

    public function delete(int $brandId): bool
    {
        return $this->db()->table('tbl_brand')
            ->where('brand_id', $brandId)
            ->delete();
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
