<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;

final class BackendCategoryModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    public function get_all_category(): array
    {
        return $this->db()->table('tbl_category')
            ->where('parent_id', 0)
            ->orderBy('category_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function get_all_sub_category(): array
    {
        return $this->getAllCategories();
    }

    public function get_all_sub_sub_category(): array
    {
        return $this->getAllCategories();
    }

    public function get_sub_category(string|int $parentId): array
    {
        return $this->db()->table('tbl_category')
            ->where('parent_id', $parentId)
            ->orderBy('category_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function get_sub_sub_category(string|int $parentId): array
    {
        return $this->get_sub_category($parentId);
    }

    public function getById(int $categoryId): ?object
    {
        $category = $this->db()->table('tbl_category')
            ->where('category_id', $categoryId)
            ->get()
            ->getRow();

        return $category === null ? null : (object) $category;
    }

    public function exists(int $categoryId): bool
    {
        return $this->db()->table('tbl_category')
            ->where('category_id', $categoryId)
            ->countAllResults() > 0;
    }

    public function create(string $name, string $slug, int $parentId = 0): bool
    {
        return $this->db()->table('tbl_category')->insert([
            'category_name'     => $name,
            'category_url_name' => $slug,
            'parent_id'         => $parentId,
            'category_status'   => 1,
        ]);
    }

    public function update(int $categoryId, string $name, string $slug): bool
    {
        return $this->db()->table('tbl_category')
            ->where('category_id', $categoryId)
            ->update([
                'category_name'     => $name,
                'category_url_name' => $slug,
            ]);
    }

    public function deleteTree(int $categoryId): bool
    {
        $ids = [$categoryId];
        $pending = [$categoryId];

        while ($pending !== []) {
            $children = $this->db()->table('tbl_category')
                ->select('category_id')
                ->whereIn('parent_id', $pending)
                ->get()
                ->getResultArray();
            $pending = array_map(static fn (array $row): int => (int) $row['category_id'], $children);
            $ids = array_merge($ids, $pending);
        }

        return $this->db()->table('tbl_category')
            ->whereIn('category_id', array_values(array_unique($ids)))
            ->delete();
    }

    private function getAllCategories(): array
    {
        return $this->db()->table('tbl_category')
            ->orderBy('category_id', 'DESC')
            ->get()
            ->getResult();
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
