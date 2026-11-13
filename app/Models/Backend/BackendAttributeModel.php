<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;
use RuntimeException;

final class BackendAttributeModel
{
    private const ATTRIBUTES = [
        'tags' => [
            'table'       => 'tbl_product_tags',
            'id'          => 'product_tag_id',
            'name'        => 'product_tag_name',
            'slug'        => 'product_tag_slug',
            'description' => 'product_tag_description',
        ],
        'type' => [
            'table'       => 'tbl_product_type',
            'id'          => 'product_type_id',
            'name'        => 'product_type_name',
            'slug'        => 'product_type_slug',
            'description' => 'product_type_description',
        ],
        'size' => [
            'table'       => 'tbl_size',
            'id'          => 'size_id',
            'name'        => 'size_name',
            'slug'        => 'size_slug',
            'description' => 'size_description',
        ],
        'color' => [
            'table'       => 'tbl_color',
            'id'          => 'color_id',
            'name'        => 'color',
            'slug'        => 'color_slug',
            'description' => 'color_description',
        ],
        'search' => [
            'table'       => 'tbl_product_search_keyword',
            'id'          => 'search_key_id',
            'name'        => 'search_key_name',
            'slug'        => 'search_key_slug',
            'description' => 'search_key_description',
        ],
    ];

    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    public function all(string $attribute): array
    {
        $config = $this->config($attribute);

        return $this->db()->table($config['table'])->get()->getResult();
    }

    public function find(string $attribute, int $id): ?object
    {
        $config = $this->config($attribute);
        $row    = $this->db()->table($config['table'])
            ->where($config['id'], $id)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function nameExists(string $attribute, string $name, ?int $exceptId = null): bool
    {
        $config  = $this->config($attribute);
        $builder = $this->db()->table($config['table'])
            ->where($config['name'], $name);

        if ($exceptId !== null) {
            $builder->where($config['id'] . ' !=', $exceptId);
        }

        return $builder->countAllResults() > 0;
    }

    public function create(string $attribute, string $name, string $slug, string $description): bool
    {
        $config = $this->config($attribute);

        return $this->db()->table($config['table'])->insert([
            $config['name']        => $name,
            $config['slug']        => $slug,
            $config['description'] => $description,
        ]);
    }

    public function update(string $attribute, int $id, string $name, string $slug, string $description): bool
    {
        $config = $this->config($attribute);

        return $this->db()->table($config['table'])
            ->where($config['id'], $id)
            ->update([
                $config['name']        => $name,
                $config['slug']        => $slug,
                $config['description'] => $description,
            ]);
    }

    public function delete(string $attribute, int $id): bool
    {
        $config = $this->config($attribute);

        return $this->db()->table($config['table'])
            ->where($config['id'], $id)
            ->delete();
    }

    public function colorRelationsForProduct(int $productId): array
    {
        return $this->db()->table('tbl_attr_relation_color TRC')
            ->select('TRC.attr_color_relation_product_id, TRC.attr_color_relation_sku_name, TRC.attr_relation_color_image, TRC.attr_relation_color_name, TC.color')
            ->join('tbl_color TC', 'TRC.attr_relation_color_name = TC.color_id', 'left')
            ->where('TRC.attr_color_relation_product_id', $productId)
            ->get()
            ->getResult();
    }

    public function attributeImagesForProduct(int $productId): array
    {
        return $this->db()->table('tbl_img_attr TR')
            ->select('TR.*, TRC.attr_relation_color_image, TC.color')
            ->join(
                'tbl_attr_relation_color TRC',
                'TR.attr_relation_color_name = TRC.attr_relation_color_name AND TR.product_id = TRC.attr_color_relation_product_id',
                'inner'
            )
            ->join('tbl_color TC', 'TRC.attr_relation_color_name = TC.color_id', 'inner')
            ->where('TR.product_id', $productId)
            ->get()
            ->getResult();
    }

    public function findColorRelation(int $productId, int $colorId): ?object
    {
        $row = $this->db()->table('tbl_attr_relation_color')
            ->where('attr_color_relation_product_id', $productId)
            ->where('attr_relation_color_name', $colorId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @param list<array{product_id: int, attr_relation_color_name: int, image: string}> $images
     */
    public function createAttributeImages(array $images): bool
    {
        $database = $this->db();
        if (! $database->transBegin()) {
            return false;
        }

        foreach ($images as $image) {
            if (! $database->table('tbl_img_attr')->insert($image)) {
                $database->transRollback();

                return false;
            }
        }

        $database->transCommit();

        return $database->transStatus();
    }

    public function findAttributeImage(int $imageId): ?object
    {
        $row = $this->db()->table('tbl_img_attr')
            ->where('attrimg_id', $imageId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    public function deleteAttributeImage(int $imageId): bool
    {
        return $this->db()->table('tbl_img_attr')
            ->where('attrimg_id', $imageId)
            ->delete();
    }

    public function normalizeColorImagePaths(): int
    {
        $database = $this->db();
        $rows     = $database->table('tbl_attr_relation_color')
            ->select('attr_color_relation_id, attr_relation_color_image')
            ->get()
            ->getResult();
        $updated = 0;

        foreach ($rows as $row) {
            $image = trim((string) $row->attr_relation_color_image);
            $normalized = str_replace('uploads/psize/', '', $image);
            if ($normalized === $image) {
                continue;
            }

            if (! $database->table('tbl_attr_relation_color')
                ->where('attr_color_relation_id', $row->attr_color_relation_id)
                ->update(['attr_relation_color_image' => $normalized])) {
                throw new RuntimeException('Unable to normalize product color image paths.');
            }

            $updated++;
        }

        return $updated;
    }

    public function deleteProductFeatureImage(int $imageId): bool
    {
        return $this->db()->table('tbl_image')
            ->where('id', $imageId)
            ->delete();
    }

    /**
     * @return array{table: string, id: string, name: string, slug: string, description: string}
     */
    private function config(string $attribute): array
    {
        if (! isset(self::ATTRIBUTES[$attribute])) {
            throw new \InvalidArgumentException('Unknown product attribute.');
        }

        return self::ATTRIBUTES[$attribute];
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
