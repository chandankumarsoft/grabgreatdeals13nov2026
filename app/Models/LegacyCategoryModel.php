<?php

namespace App\Models;

use CodeIgniter\Database\BaseConnection;

final class LegacyCategoryModel
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = db_connect();
    }

    /**
     * @return list<object>
     */
    public function get_all_category_front(): array
    {
        return $this->database->table('tbl_category')
            ->orderBy('order_data', 'DESC')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function checkProductAvailabilityById(int|string $categoryId): array
    {
        $categoryIds = $this->getDescendantIds($categoryId);

        if ($categoryIds === []) {
            return [];
        }

        return $this->database->table('tbl_product_relation PR')
            ->distinct()
            ->select('PR.product_rel_id')
            ->join('tbl_product P', 'PR.product_id = P.pro_id', 'inner')
            ->where('P.pro_status', '1')
            ->whereIn('PR.product_cat_id', $categoryIds)
            ->get()
            ->getResult();
    }

    public function getCategoryBySlug(string $slug, int|string|null $parentId = null): ?object
    {
        $builder = $this->database->table('tbl_category')
            ->where('category_url_name', $slug);

        if ($parentId !== null) {
            $builder->where('parent_id', $parentId);
        }

        return $builder->get()->getRow();
    }

    /**
     * @return list<int|string>
     */
    public function getDescendantIds(int|string $categoryId): array
    {
        $categoryIds = [];
        $frontier    = [$categoryId];

        while ($frontier !== []) {
            $current = array_values(array_diff($frontier, $categoryIds));

            if ($current === []) {
                break;
            }

            $categoryIds = array_merge($categoryIds, $current);
            $children    = $this->database->table('tbl_category')
                ->select('category_id')
                ->whereIn('parent_id', $current)
                ->get()
                ->getResultArray();
            $frontier = array_column($children, 'category_id');
        }

        return array_values(array_unique($categoryIds));
    }

    public function getRootCategoryId(int|string $categoryId): ?int
    {
        $current = $this->database->table('tbl_category')
            ->select('category_id, parent_id')
            ->where('category_id', $categoryId)
            ->get()
            ->getRow();

        if ($current === null) {
            return null;
        }

        while ((int) $current->parent_id !== 0) {
            $current = $this->database->table('tbl_category')
                ->select('category_id, parent_id')
                ->where('category_id', $current->parent_id)
                ->get()
                ->getRow();

            if ($current === null) {
                return null;
            }
        }

        return (int) $current->category_id;
    }

    /**
     * @return list<array{category_id: int|string, category_name: string, totalProd: int}>
     */
    public function getRootCategoriesWithProductCounts(): array
    {
        $categories = $this->database->table('tbl_category')
            ->where('parent_id', 0)
            ->get()
            ->getResult();
        $result = [];

        foreach ($categories as $category) {
            $categoryIds = $this->getDescendantIds($category->category_id);
            $count       = $this->database->table('tbl_product_relation PR')
                ->select('COUNT(DISTINCT P.pro_id) AS total', false)
                ->join('tbl_product P', 'PR.product_id = P.pro_id', 'inner')
                ->where('P.pro_status', '1')
                ->whereIn('PR.product_cat_id', $categoryIds)
                ->get()
                ->getRow();

            if ((int) ($count->total ?? 0) > 0) {
                $result[] = [
                    'category_id'   => $category->category_id,
                    'category_name' => $category->category_name,
                    'totalProd'     => (int) $count->total,
                ];
            }
        }

        return $result;
    }
}
