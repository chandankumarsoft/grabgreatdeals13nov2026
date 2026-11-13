<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;

final class LegacySearchModel
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = db_connect();
    }

    /**
     * @return list<int|string>
     */
    public function getCategoryIdsByName(string $search): array
    {
        helper('text');
        $slug = url_title($search, '-', true);
        if ($slug === '') {
            return [];
        }

        $categories = $this->database->table('tbl_category')
            ->select('category_id')
            ->like('category_url_name', $slug)
            ->get()
            ->getResultArray();
        $ids = [];
        $categoryModel = new LegacyCategoryModel();
        foreach ($categories as $category) {
            $ids = array_merge($ids, $categoryModel->getDescendantIds($category['category_id']));
        }

        return array_values(array_unique($ids));
    }

    /**
     * @param list<int|string> $categoryIds
     * @return list<object>
     */
    public function getSearchProducts(string $search, array $categoryIds): array
    {
        $builder = $this->database->table('tbl_product P')
            ->select("P.*, GROUP_CONCAT(DISTINCT PSD.pro_short_desc_content SEPARATOR '=') AS pro_short_desc_details", false)
            ->join('tbl_product_short_desc PSD', 'PSD.pro_id = P.pro_id', 'left')
            ->where('P.pro_status', '1');

        if ($categoryIds !== []) {
            $builder->join('tbl_product_relation PR', 'PR.product_id = P.pro_id', 'left');
            $builder->groupStart()
                ->whereIn('PR.product_cat_id', $categoryIds)
                ->orLike('P.pro_title', $search)
                ->orLike('P.pro_price', $search)
                ->groupEnd();
        } else {
            $builder->groupStart()
                ->like('P.pro_title', $search)
                ->orLike('P.pro_price', $search)
                ->groupEnd();
        }

        return $builder->groupBy('P.pro_id')->get()->getResult();
    }

    /**
     * @param array<string, mixed> $filters
     * @return list<object>
     */
    public function filterProducts(array $filters, int $limit = 10, int $offset = 0): array
    {
        $builder = $this->database->table('tbl_product P')
            ->select("P.*, GROUP_CONCAT(DISTINCT PSD.pro_short_desc_content SEPARATOR '=') AS pro_short_desc_details", false)
            ->join('tbl_product_short_desc PSD', 'PSD.pro_id = P.pro_id', 'left')
            ->where('P.pro_status', '1');
        $this->applyFilters($builder, $filters);
        $this->applySort($builder, $filters['sort'] ?? '');

        return $builder->groupBy('P.pro_id')
            ->limit($limit, $offset)
            ->get()
            ->getResult();
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function countFilteredProducts(array $filters): int
    {
        $builder = $this->database->table('tbl_product P')
            ->select('COUNT(DISTINCT P.pro_id) AS total', false)
            ->where('P.pro_status', '1');
        $this->applyFilters($builder, $filters);
        $result = $builder->get()->getRow();

        return (int) ($result->total ?? 0);
    }

    /**
     * @return list<object>
     */
    public function getBackendProductsByName(string $name): array
    {
        return $this->database->table('tbl_product')
            ->like('pro_title', $name)
            ->get()
            ->getResult();
    }

    private function applyFilters(BaseBuilder $builder, array $filters): void
    {
        $minimum = $filters['minimum'] ?? null;
        $maximum = $filters['maximum'] ?? null;
        if (is_numeric($minimum) && is_numeric($maximum) && (float) $minimum <= (float) $maximum) {
            $builder->where('P.pro_price >=', (float) $minimum)
                ->where('P.pro_price <=', (float) $maximum);
        }

        $brands = $this->validIds($filters['brands'] ?? []);
        if ($brands !== []) {
            $builder->whereIn('P.pro_brand', $brands);
        }

        $categories = $this->validIds($filters['categories'] ?? []);
        if ($categories !== []) {
            $categoryModel = new LegacyCategoryModel();
            $expandedCategories = [];
            foreach ($categories as $categoryId) {
                $expandedCategories = array_merge(
                    $expandedCategories,
                    $categoryModel->getDescendantIds($categoryId),
                );
            }
            $builder->join('tbl_product_relation PR', 'PR.product_id = P.pro_id', 'inner')
                ->whereIn('PR.product_cat_id', array_values(array_unique($expandedCategories)));
        }

        $colors = $this->validIds($filters['colors'] ?? []);
        $sizes = $this->validIds($filters['sizes'] ?? []);
        if ($colors !== []) {
            $builder->join('tbl_attr_relation ARC', 'ARC.attr_relation_product_id = P.pro_id', 'inner')
                ->whereIn('ARC.attr_relation_color_name', $colors);
        }
        if ($sizes !== []) {
            $builder->join('tbl_attr_relation ARS', 'ARS.attr_relation_product_id = P.pro_id', 'inner')
                ->whereIn('ARS.attr_relation_size_name', $sizes);
        }

        $ratings = $this->validIds($filters['ratings'] ?? []);
        if ($ratings !== []) {
            $builder->join('tbl_product_review RV', 'RV.product_id = P.pro_id', 'inner')
                ->whereIn('RV.review_average', $ratings);
        }

        $arrivalDays = $this->validIds($filters['arrival_days'] ?? []);
        if ($arrivalDays !== []) {
            $days = max(array_map('intval', $arrivalDays));
            $builder->where('P.pro_created_on >=', date('Y-m-d H:i:s', strtotime("-{$days} days")));
        }

        $tags = $this->validIds($filters['tags'] ?? []);
        if ($tags !== []) {
            $builder->join('tbl_product_tags_relation PTR', 'PTR.product_id = P.pro_id', 'inner')
                ->whereIn('PTR.product_tag_id', $tags);
        }
    }

    private function applySort(BaseBuilder $builder, mixed $sort): void
    {
        $sorts = [
            'pro_price_asc'         => ['P.pro_price', 'ASC'],
            'pro_price_desc'        => ['P.pro_price', 'DESC'],
            'pro_created_on_asc'    => ['P.pro_created_on', 'ASC'],
            'pro_created_on_desc'   => ['P.pro_created_on', 'DESC'],
        ];
        if (is_string($sort) && isset($sorts[$sort])) {
            $builder->orderBy($sorts[$sort][0], $sorts[$sort][1]);
        }
    }

    /**
     * @return list<int>
     */
    private function validIds(mixed $values): array
    {
        if (! is_array($values)) {
            return [];
        }

        $ids = [];
        foreach ($values as $value) {
            if (is_scalar($value) && ctype_digit((string) $value) && (int) $value > 0) {
                $ids[] = (int) $value;
            }
        }

        return array_values(array_unique($ids));
    }
}
