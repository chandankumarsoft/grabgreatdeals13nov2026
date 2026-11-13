<?php

namespace App\Models;

use CodeIgniter\Database\BaseConnection;

final class LegacyProductModel
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = db_connect();
    }

    public function get_hot_deals(): array
    {
        return $this->getFeatured('is_hot_sale', 10, true);
    }

    public function get_all_product_recent(): array
    {
        return $this->getFeatured('is_recent', 10, true);
    }

    public function get_all_product_special(): array
    {
        return $this->getFeatured('is_special', 10, true);
    }

    public function get_all_top_rated_product(): array
    {
        return $this->getFeatured('is_toprated', 3, true);
    }

    public function get_all_product_topseller(): array
    {
        return $this->getFeatured('is_topseller', 3, true);
    }

    /**
     * @return list<object>
     */
    public function get_halloween(): array
    {
        return $this->getProductsByCategoryId(236, 10);
    }

    /**
     * @return list<object>
     */
    public function get_christmas(): array
    {
        return $this->getProductsByCategoryId(248, 10);
    }

    /**
     * @return list<object>
     */
    public function get_valentine(): array
    {
        return $this->getProductsByCategoryId(260, 100);
    }

    public function get_all_bestdeals_product(): array
    {
        return $this->getFeatured('is_best_rate', 3, true);
    }

    public function getProductBySlug(string $slug): ?object
    {
        $product = $this->database->table('tbl_product P')
            ->select('P.*, B.brand_name')
            ->join('tbl_brand B', 'P.pro_brand = B.brand_id', 'left')
            ->where('P.pro_title_slug', $slug)
            ->get()
            ->getRow();

        if ($product === null) {
            return null;
        }

        $shortDescription = $this->database->table('tbl_product_short_desc')
            ->select('GROUP_CONCAT(DISTINCT pro_short_desc_content SEPARATOR "=") AS pro_short_desc_details', false)
            ->where('pro_id', $product->pro_id)
            ->get()
            ->getRow();
        $category = $this->database->table('tbl_product_relation')
            ->select('product_cat_id')
            ->where('product_id', $product->pro_id)
            ->orderBy('product_cat_id', 'DESC')
            ->get()
            ->getRow();

        $product->pro_cat = $category->product_cat_id ?? null;
        $product->pro_short_desc_details = $shortDescription->pro_short_desc_details ?? '';

        return $product;
    }

    public function getProductById(int|string $productId): ?object
    {
        return $this->database->table('tbl_product')
            ->where('pro_id', $productId)
            ->get()
            ->getRow();
    }

    /**
     * @return list<object>
     */
    public function getAttributeImagesForColor(int $productId, int $colorId): array
    {
        return $this->database->table('tbl_img_attr')
            ->where('product_id', $productId)
            ->where('attr_relation_color_name', $colorId)
            ->get()
            ->getResult();
    }

    /**
     * @param list<int|string> $categoryIds
     * @return list<object>
     */
    public function getProductsByCategory(array $categoryIds, int $offset): array
    {
        if ($categoryIds === []) {
            return [];
        }

        return $this->database->table('tbl_product_relation PR')
            ->select(
                "P.*, GROUP_CONCAT(DISTINCT PSD.pro_short_desc_content SEPARATOR '=') AS pro_short_desc_details",
                false,
            )
            ->join('tbl_product P', 'PR.product_id = P.pro_id', 'inner')
            ->join('tbl_product_short_desc PSD', 'PSD.pro_id = P.pro_id', 'left')
            ->where('P.pro_status', '1')
            ->whereIn('PR.product_cat_id', $categoryIds)
            ->groupBy('P.pro_id')
            ->limit(10, $offset)
            ->get()
            ->getResult();
    }

    /**
     * @param list<int|string> $categoryIds
     */
    public function countProductsByCategory(array $categoryIds): int
    {
        if ($categoryIds === []) {
            return 0;
        }

        $count = $this->database->table('tbl_product_relation PR')
            ->select('COUNT(DISTINCT P.pro_id) AS total', false)
            ->join('tbl_product P', 'PR.product_id = P.pro_id', 'inner')
            ->where('P.pro_status', '1')
            ->whereIn('PR.product_cat_id', $categoryIds)
            ->get()
            ->getRow();

        return (int) ($count->total ?? 0);
    }

    public function getShopProducts(int $offset): array
    {
        return $this->database->table('tbl_product P')
            ->select("P.*, GROUP_CONCAT(DISTINCT PSD.pro_short_desc_content SEPARATOR '=') AS pro_short_desc_details", false)
            ->join('tbl_product_short_desc PSD', 'PSD.pro_id = P.pro_id', 'left')
            ->where('P.pro_status', '1')
            ->groupBy('P.pro_id')
            ->limit(10, $offset)
            ->get()
            ->getResult();
    }

    public function countShopProducts(): int
    {
        return (int) $this->database->table('tbl_product')
            ->where('pro_status', '1')
            ->countAllResults();
    }

    /**
     * @return list<object>
     */
    public function getProductsByType(string $productType): array
    {
        if (preg_match('/\Ais_[a-z_]+\z/', $productType) !== 1) {
            throw new \InvalidArgumentException('Invalid product type.');
        }

        $type = $this->database->table('tbl_product_type')
            ->select('pro_type_name')
            ->where('pro_type_name', $productType)
            ->get()
            ->getRow();

        if ($type === null) {
            return [];
        }

        return $this->database->table('tbl_product')
            ->where($type->pro_type_name, '1')
            ->where('pro_status', '1')
            ->orderBy('RAND()', '', false)
            ->get()
            ->getResult();
    }

    public function getProductTypeName(string $productType): ?object
    {
        return $this->database->table('tbl_product_type')
            ->select('product_type_name')
            ->where('pro_type_name', $productType)
            ->get()
            ->getRow();
    }

    /**
     * @param list<int|string> $categoryIds
     * @return list<object>
     */
    public function getRelatedProducts(array $categoryIds, int|string $excludeProductId): array
    {
        if ($categoryIds === []) {
            return [];
        }

        return $this->database->table('tbl_product P')
            ->distinct()
            ->select('P.*')
            ->join('tbl_product_relation PR', 'P.pro_id = PR.product_id', 'inner')
            ->whereIn('PR.product_cat_id', $categoryIds)
            ->where('P.pro_id !=', $excludeProductId)
            ->limit(10)
            ->get()
            ->getResult();
    }

    public function getPriceRange(): ?object
    {
        return $this->database->table('tbl_product')
            ->select('MIN(pro_price) AS min_pro_price, MAX(pro_price) AS max_pro_price', false)
            ->get()
            ->getRow();
    }

    private function getFeatured(string $flag, int $limit, bool $random): array
    {
        if (preg_match('/\Ais_[a-z_]+\z/', $flag) !== 1) {
            throw new \InvalidArgumentException('Invalid product feature flag.');
        }

        $builder = $this->database->table('tbl_product')
            ->where($flag, '1')
            ->where('pro_status', '1');

        if ($random) {
            $builder->orderBy('RAND()', '', false);
        }

        return $builder->limit($limit)
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    private function getProductsByCategoryId(int $categoryId, int $limit): array
    {
        return $this->database->table('tbl_product P')
            ->select('P.*')
            ->join('tbl_product_relation PR', 'P.pro_id = PR.product_id', 'inner')
            ->where('PR.product_cat_id', $categoryId)
            ->limit($limit)
            ->get()
            ->getResult();
    }
}
