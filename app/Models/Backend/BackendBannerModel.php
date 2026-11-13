<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;

final class BackendBannerModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    public function all(): array
    {
        return $this->db()->table('tbl_baner')
            ->orderBy('baner_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function find(int $bannerId): ?object
    {
        $banner = $this->db()->table('tbl_baner')
            ->where('baner_id', $bannerId)
            ->get()
            ->getRow();

        return $banner === null ? null : (object) $banner;
    }

    public function create(array $data): bool
    {
        return $this->db()->table('tbl_baner')->insert($data);
    }

    public function update(int $bannerId, array $data): bool
    {
        return $this->db()->table('tbl_baner')
            ->where('baner_id', $bannerId)
            ->update($data);
    }

    public function delete(int $bannerId): bool
    {
        return $this->db()->table('tbl_baner')
            ->where('baner_id', $bannerId)
            ->delete();
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
