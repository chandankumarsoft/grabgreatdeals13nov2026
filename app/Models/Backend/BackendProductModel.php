<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use RuntimeException;

final class BackendProductModel
{
    private const PRODUCT_TYPES = [
        'is_normal',
        'is_featured',
        'is_topseller',
        'is_special',
        'is_hot_sale',
        'is_recent',
        'is_toprated',
        'is_onsale',
        'is_best_rate',
    ];

    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @param array<string, mixed> $filters
     * @return list<object>
     */
    public function backendProducts(array $filters = [], ?int $limit = null, int $offset = 0): array
    {
        $builder = $this->db()->table('tbl_product P')
            ->select('P.pro_id, P.pro_title, P.pro_image, P.pro_status, P.pro_availability, P.pro_quantity, P.pro_price, P.pro_offer_price, P.pro_created_on');
        $this->applyBackendFilters($builder, $filters);
        $builder->orderBy('P.pro_id', 'DESC');

        if ($limit !== null) {
            $builder->limit($limit, max(0, $offset));
        }

        return $builder->get()->getResult();
    }

    /**
     * @param array<string, mixed> $filters
     */
    public function countBackendProducts(array $filters = []): int
    {
        $builder = $this->db()->table('tbl_product P')
            ->select('COUNT(DISTINCT P.pro_id) AS total', false);
        $this->applyBackendFilters($builder, $filters);

        return (int) ($builder->get()->getRow()->total ?? 0);
    }

    /**
     * @return list<object>
     */
    public function backendProductsByName(string $name, ?int $limit = null, int $offset = 0): array
    {
        $builder = $this->db()->table('tbl_product P')
            ->select('P.pro_id, P.pro_title, P.pro_image, P.pro_status, P.pro_availability, P.pro_quantity, P.pro_price, P.pro_offer_price, P.pro_created_on')
            ->like('P.pro_title', $name)
            ->orderBy('P.pro_id', 'DESC');

        if ($limit !== null) {
            $builder->limit($limit, max(0, $offset));
        }

        return $builder->get()->getResult();
    }

    public function countBackendProductsByName(string $name): int
    {
        return $this->db()->table('tbl_product')
            ->like('pro_title', $name)
            ->countAllResults();
    }

    /**
     * @return list<object>
     */
    public function videos(): array
    {
        return $this->db()->table('tbl_product')
            ->select('pro_id, product_sku_name, product_video_name')
            ->where('product_video_name IS NOT NULL', null, false)
            ->where('product_video_name !=', '')
            ->orderBy('pro_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function product(int $productId): ?object
    {
        $row = $this->db()->table('tbl_product')
            ->where('pro_id', $productId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @return list<object>
     */
    public function get_all_category_of_product(int $productId): array
    {
        return $this->db()->table('tbl_product_relation')
            ->select('product_cat_id')
            ->where('product_id', $productId)
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function get_all_pro_shortdesc(int $productId): array
    {
        return $this->db()->table('tbl_product_short_desc')
            ->select('pro_short_desc_id, pro_short_desc_content')
            ->where('pro_id', $productId)
            ->get()
            ->getResult();
    }

    public function edit_product_model(int $productId): ?object
    {
        return $this->product($productId);
    }

    /**
     * @return list<object>
     */
    public function allBrands(): array
    {
        return $this->db()->table('tbl_brand')
            ->orderBy('brand_id', 'DESC')
            ->get()
            ->getResult();
    }

    /**
     * CI3 view compatibility for seller product forms.
     *
     * @return list<object>
     */
    public function get_all_brand(): array
    {
        return $this->allBrands();
    }

    public function findBySku(string $sku): ?object
    {
        $row = $this->db()->table('tbl_product')
            ->select('pro_id, product_sku_name, product_video_name')
            ->where('product_sku_name', $sku)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @return list<object>
     */
    public function upsellCandidates(int $referenceProductId): array
    {
        return $this->db()->table('tbl_product')
            ->select('pro_id, pro_title')
            ->where('pro_id !=', $referenceProductId)
            ->orderBy('pro_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function upsellProduct(int $referenceProductId): ?object
    {
        $row = $this->db()->table('tbl_upsell_product U')
            ->select('U.*, P.pro_title, P.pro_image')
            ->join('tbl_product P', 'U.upsell_pro_id = P.pro_id')
            ->where('U.reference_pro_id', $referenceProductId)
            ->orderBy('U.upsell_id', 'DESC')
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function addUpsellProduct(int $upsellProductId, int $referenceProductId): bool
    {
        return $this->db()->table('tbl_upsell_product')->insert([
            'upsell_pro_id' => $upsellProductId,
            'reference_pro_id' => $referenceProductId,
        ]);
    }

    public function deleteUpsellProducts(int $referenceProductId): bool
    {
        return $this->db()->table('tbl_upsell_product')
            ->where('reference_pro_id', $referenceProductId)
            ->delete();
    }

    public function findVideoProduct(int $productId): ?object
    {
        $row = $this->db()->table('tbl_product')
            ->select('pro_id, product_sku_name, product_video_name')
            ->where('pro_id', $productId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function updateVideo(int $productId, ?string $videoName): bool
    {
        return $this->db()->table('tbl_product')
            ->where('pro_id', $productId)
            ->update(['product_video_name' => $videoName]);
    }

    /**
     * @param array<string, mixed> $product
     * @param list<int> $categoryIds
     * @param list<string> $shortDescriptions
     * @param list<array{size_id: int, regular_price: string, sale_price: string, quantity: int}> $sizes
     * @param list<array{name: string, image: string, regular_price: string, sale_price: string, quantity: int}> $colors
     * @param list<string> $tags
     * @param list<string> $keywords
     * @param list<string> $featureImages
     */
    public function createProduct(
        array $product,
        array $categoryIds,
        array $shortDescriptions,
        array $sizes,
        array $colors,
        array $tags,
        array $keywords,
        array $featureImages,
    ): int {
        $database = $this->db();
        $database->transBegin();

        try {
            if (! $database->table('tbl_product')->insert($product)) {
                throw new RuntimeException('Unable to create the product.');
            }
            $productId = (int) $database->insertID();
            $this->insertProductRelations($productId, $product, $categoryIds, $shortDescriptions, $sizes, $colors, $tags, $keywords, $featureImages);
            if (! $database->table('tbl_shipping_charge_relation')->insert(['pro_id' => $productId, 'ship_charge_id' => 1])) {
                throw new RuntimeException('Unable to set the product shipping relation.');
            }
            $database->transCommit();

            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to save product details.');
            }

            return $productId;
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    /**
     * @param array<string, mixed> $product
     * @param list<int> $categoryIds
     * @param list<string> $shortDescriptions
     * @param list<array{size_id: int, regular_price: string, sale_price: string, quantity: int}> $sizes
     * @param list<array{name: string, image: string, regular_price: string, sale_price: string, quantity: int}> $colors
     * @param list<string> $tags
     * @param list<string> $keywords
     * @param list<string> $featureImages
     */
    public function updateProduct(
        int $productId,
        array $product,
        array $categoryIds,
        array $shortDescriptions,
        array $sizes,
        array $colors,
        array $tags,
        array $keywords,
        array $featureImages,
    ): bool {
        $database = $this->db();
        $database->transBegin();

        try {
            if (! $database->table('tbl_product')->where('pro_id', $productId)->update($product)) {
                throw new RuntimeException('Unable to update the product.');
            }

            foreach ([
                ['tbl_product_relation', 'product_id'],
                ['tbl_product_short_desc', 'pro_id'],
                ['tbl_product_tags_relation', 'product_id'],
                ['tbl_search_keyword_relation', 'product_id'],
                ['tbl_attr_relation_size', 'attr_size_relation_product_id'],
                ['tbl_attr_relation_color', 'attr_color_relation_product_id'],
            ] as [$table, $column]) {
                if (! $database->table($table)->where($column, $productId)->delete()) {
                    throw new RuntimeException('Unable to replace product details.');
                }
            }

            $this->insertProductRelations($productId, $product, $categoryIds, $shortDescriptions, $sizes, $colors, $tags, $keywords, $featureImages);
            $database->transCommit();

            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to save product details.');
            }

            return true;
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    public function deleteProduct(int $productId): bool
    {
        $database = $this->db();
        $database->transBegin();

        try {
            foreach ([
                ['tbl_product_relation', 'product_id'],
                ['tbl_product_short_desc', 'pro_id'],
                ['tbl_product_tags_relation', 'product_id'],
                ['tbl_search_keyword_relation', 'product_id'],
                ['tbl_attr_relation_size', 'attr_size_relation_product_id'],
                ['tbl_attr_relation_color', 'attr_color_relation_product_id'],
                ['tbl_img_attr', 'product_id'],
                ['tbl_image', 'img_rel_id'],
                ['tbl_shipping_charge_relation', 'pro_id'],
            ] as [$table, $column]) {
                if (! $database->table($table)->where($column, $productId)->delete()) {
                    throw new RuntimeException('Unable to remove product details.');
                }
            }

            if (! $database->table('tbl_product')->where('pro_id', $productId)->delete()) {
                throw new RuntimeException('Unable to delete the product.');
            }
            $database->transCommit();

            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to delete product details.');
            }

            return true;
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    /**
     * @param array<string, mixed> $product
     * @param list<int> $categoryIds
     * @param list<string> $shortDescriptions
     * @param list<array{size_id: int, regular_price: string, sale_price: string, quantity: int}> $sizes
     * @param list<array{name: string, image: string, regular_price: string, sale_price: string, quantity: int}> $colors
     * @param list<string> $tags
     * @param list<string> $keywords
     * @param list<string> $featureImages
     */
    private function insertProductRelations(
        int $productId,
        array $product,
        array $categoryIds,
        array $shortDescriptions,
        array $sizes,
        array $colors,
        array $tags,
        array $keywords,
        array $featureImages,
    ): void {
        helper('text');
        $database = $this->db();

        foreach ($categoryIds as $categoryId) {
            $this->insertOrFail('tbl_product_relation', ['product_id' => $productId, 'product_cat_id' => $categoryId]);
        }
        foreach ($shortDescriptions as $description) {
            $this->insertOrFail('tbl_product_short_desc', ['pro_id' => $productId, 'pro_short_desc_content' => $description]);
        }
        foreach ($sizes as $index => $size) {
            if ($size['size_id'] < 1) {
                continue;
            }
            $this->insertOrFail('tbl_attr_relation_size', [
                'attr_size_relation_product_id' => $productId,
                'attr_size_reference_id' => $index + 1,
                'attr_size_relation_sku_name' => $product['product_sku_name'],
                'attr_relation_size_name' => $size['size_id'],
                'attr_relation_size_regular_price' => $size['regular_price'],
                'attr_relation_size_sale_price' => $size['sale_price'],
                'attr_relation_size_quantity' => $size['quantity'],
            ]);
        }
        foreach ($colors as $index => $color) {
            if ($color['name'] === '') {
                continue;
            }
            $colorId = $this->getOrCreateColor($color['name']);
            $this->insertOrFail('tbl_attr_relation_color', [
                'attr_color_relation_product_id' => $productId,
                'attr_color_reference_id' => $index + 1,
                'attr_color_relation_sku_name' => $product['product_sku_name'],
                'attr_relation_color_name' => $colorId,
                'attr_relation_color_image' => $color['image'],
                'attr_relation_color_regular_price' => $color['regular_price'],
                'attr_relation_color_sale_price' => $color['sale_price'],
                'attr_relation_color_quantity' => $color['quantity'],
            ]);
        }
        foreach ($tags as $tag) {
            $tagId = $this->getOrCreateLookup('tbl_product_tags', 'product_tag_id', 'product_tag_name', 'product_tag_slug', $tag);
            $this->insertOrFail('tbl_product_tags_relation', [
                'product_id' => $productId,
                'product_tag_id' => $tagId,
                'product_tag_name' => $tag,
                'product_tag_slug' => url_title(strtolower($tag)),
            ]);
        }
        foreach ($keywords as $keyword) {
            $keyId = $this->getOrCreateLookup('tbl_product_search_keyword', 'search_key_id', 'search_key_name', 'search_key_slug', $keyword);
            $this->insertOrFail('tbl_search_keyword_relation', [
                'product_id' => $productId,
                'product_search_key_id' => $keyId,
                'search_keyword_name' => $keyword,
                'product_search_key_slug' => url_title(strtolower($keyword)),
            ]);
        }
        foreach ($featureImages as $image) {
            $this->insertOrFail('tbl_image', [
                'image_name' => $image,
                'img_rel_id' => $productId,
                'img_rel_cat_id' => 2,
            ]);
        }
    }

    private function insertOrFail(string $table, array $data): void
    {
        if (! $this->db()->table($table)->insert($data)) {
            throw new RuntimeException('Unable to save product details.');
        }
    }

    private function getOrCreateColor(string $name): int
    {
        $normalized = ucfirst(strtolower(trim(strip_tags($name))));
        $row = $this->db()->table('tbl_color')->select('color_id')->where('color', $normalized)->get()->getRow();
        if ($row !== null) {
            return (int) $row->color_id;
        }

        $this->insertOrFail('tbl_color', [
            'color' => $normalized,
            'color_slug' => url_title(strtolower($normalized)),
        ]);

        return (int) $this->db()->insertID();
    }

    private function getOrCreateLookup(string $table, string $idColumn, string $nameColumn, string $slugColumn, string $name): int
    {
        $row = $this->db()->table($table)->select($idColumn)->where($nameColumn, $name)->get()->getRow();
        if ($row !== null) {
            return (int) $row->{$idColumn};
        }

        $this->insertOrFail($table, [
            $nameColumn => $name,
            $slugColumn => url_title(strtolower($name)),
        ]);

        return (int) $this->db()->insertID();
    }

    /**
     * @param array<string, mixed> $filters
     */
    private function applyBackendFilters(BaseBuilder $builder, array $filters): void
    {
        $categoryId = $this->positiveId($filters['category_name'] ?? null);
        if ($categoryId !== null) {
            $categoryIds = (new LegacyCategoryModel())->getDescendantIds($categoryId);
            if ($categoryIds === []) {
                $builder->where('P.pro_id', 0);
            } else {
                $productIds = $this->db()->table('tbl_product_relation')
                    ->select('product_id')
                    ->whereIn('product_cat_id', $categoryIds);
                $builder->whereIn('P.pro_id', $productIds);
            }
        }

        $tagSlug = $this->scalarFilter($filters['tag_name'] ?? null);
        if ($tagSlug !== '') {
            $productIds = $this->db()->table('tbl_product_tags_relation')
                ->select('product_id')
                ->where('product_tag_slug', $tagSlug);
            $builder->whereIn('P.pro_id', $productIds);
        }

        $searchSlug = $this->scalarFilter($filters['search_keyword_name'] ?? null);
        if ($searchSlug !== '') {
            $productIds = $this->db()->table('tbl_search_keyword_relation')
                ->select('product_id')
                ->where('product_search_key_slug', $searchSlug);
            $builder->whereIn('P.pro_id', $productIds);
        }

        $brandId = $this->positiveId($filters['brand_name'] ?? null);
        if ($brandId !== null) {
            $builder->where('P.pro_brand', $brandId);
        }

        $colorId = $this->positiveId($filters['color_name'] ?? null);
        if ($colorId !== null) {
            $productIds = $this->db()->table('tbl_attr_relation_color')
                ->select('attr_color_relation_product_id')
                ->where('attr_relation_color_name', $colorId);
            $builder->whereIn('P.pro_id', $productIds);
        }

        $sizeId = $this->positiveId($filters['size_name'] ?? null);
        if ($sizeId !== null) {
            $productIds = $this->db()->table('tbl_attr_relation_size')
                ->select('attr_size_relation_product_id')
                ->where('attr_relation_size_name', $sizeId);
            $builder->whereIn('P.pro_id', $productIds);
        }

        $type = $this->scalarFilter($filters['product_type_name'] ?? null);
        if (in_array($type, self::PRODUCT_TYPES, true)) {
            $builder->where('P.' . $type, '1');
        }

        foreach (['pro_status', 'pro_availability'] as $field) {
            $value = $this->positiveId($filters[$field] ?? null);
            if ($value !== null) {
                $builder->where('P.' . $field, $value);
            }
        }
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }

    private function scalarFilter(mixed $value): string
    {
        return is_scalar($value) ? trim((string) $value) : '';
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
