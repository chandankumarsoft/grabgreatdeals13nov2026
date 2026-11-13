<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;
use RuntimeException;

final class BackendBlogModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @return list<object>
     */
    public function blogs(): array
    {
        return $this->db()->table('tbl_blog')
            ->orderBy('blog_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function blog(int $blogId): ?object
    {
        $row = $this->db()->table('tbl_blog')
            ->where('blog_id', $blogId)
            ->get()
            ->getRow();

        return $row === null ? null : (object) $row;
    }

    /**
     * @return list<object>
     */
    public function fetch_all_tags(): array
    {
        return $this->db()->table('tbl_blog_tag')
            ->orderBy('blog_tag_name', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function fetch_all_category(): array
    {
        return $this->db()->table('tbl_blog_category')
            ->orderBy('blog_cat_name', 'ASC')
            ->get()
            ->getResult();
    }

    public function addTag(string $name): bool
    {
        helper('text');
        if ($this->db()->table('tbl_blog_tag')->where('blog_tag_name', $name)->countAllResults() > 0) {
            return false;
        }

        if (! $this->db()->table('tbl_blog_tag')->insert([
            'blog_tag_name' => $name,
            'blog_tag_slug' => url_title($name),
        ])) {
            throw new RuntimeException('Unable to add the blog tag.');
        }

        return true;
    }

    public function addCategory(string $name): bool
    {
        helper('text');
        if ($this->db()->table('tbl_blog_category')->where('blog_cat_name', $name)->countAllResults() > 0) {
            return false;
        }

        if (! $this->db()->table('tbl_blog_category')->insert([
            'blog_cat_name' => $name,
            'blog_cat_slug' => url_title($name),
        ])) {
            throw new RuntimeException('Unable to add the blog category.');
        }

        return true;
    }

    /**
     * @param list<int> $tagIds
     * @param list<int> $categoryIds
     */
    public function hasBlogRelations(array $tagIds, array $categoryIds): bool
    {
        return $this->countMatchingIds('tbl_blog_tag', 'blog_tag_id', $tagIds) === count($tagIds)
            && $this->countMatchingIds('tbl_blog_category', 'blog_cat_id', $categoryIds) === count($categoryIds);
    }

    /**
     * @param list<int> $tagIds
     * @param list<int> $categoryIds
     */
    public function createBlog(array $blog, array $tagIds, array $categoryIds): int
    {
        $database = $this->db();
        $database->transBegin();

        try {
            if (! $database->table('tbl_blog')->insert($blog)) {
                throw new RuntimeException('Unable to create the blog post.');
            }
            $blogId = (int) $database->insertID();
            $this->insertRelations($blogId, $tagIds, $categoryIds);
            $database->transCommit();
            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to save the blog post.');
            }

            return $blogId;
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    /**
     * @param list<int> $tagIds
     * @param list<int> $categoryIds
     */
    public function updateBlog(int $blogId, array $blog, array $tagIds, array $categoryIds): void
    {
        $database = $this->db();
        $database->transBegin();

        try {
            if (! $database->table('tbl_blog')->where('blog_id', $blogId)->update($blog)) {
                throw new RuntimeException('Unable to update the blog post.');
            }
            if (! $database->table('tbl_blog_relation')->where('blog_id', $blogId)->delete()) {
                throw new RuntimeException('Unable to replace blog categories and tags.');
            }
            $this->insertRelations($blogId, $tagIds, $categoryIds);
            $database->transCommit();
            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to save the blog post.');
            }
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    public function deleteBlog(int $blogId): void
    {
        $database = $this->db();
        $database->transBegin();

        try {
            if (! $database->table('tbl_blog_relation')->where('blog_id', $blogId)->delete()) {
                throw new RuntimeException('Unable to remove blog relations.');
            }
            if (! $database->table('tbl_blog')->where('blog_id', $blogId)->delete()) {
                throw new RuntimeException('Unable to delete the blog post.');
            }
            $database->transCommit();
            if (! $database->transStatus()) {
                throw new RuntimeException('Unable to delete the blog post.');
            }
        } catch (\Throwable $exception) {
            $database->transRollback();
            throw $exception;
        }
    }

    /**
     * @param list<int> $tagIds
     * @param list<int> $categoryIds
     */
    private function insertRelations(int $blogId, array $tagIds, array $categoryIds): void
    {
        foreach ($categoryIds as $categoryId) {
            foreach ($tagIds as $tagId) {
                if (! $this->db()->table('tbl_blog_relation')->insert([
                    'blog_id' => $blogId,
                    'blog_tag_id' => $tagId,
                    'blog_cat_id' => $categoryId,
                ])) {
                    throw new RuntimeException('Unable to save blog categories and tags.');
                }
            }
        }
    }

    /**
     * @param list<int> $ids
     */
    private function countMatchingIds(string $table, string $column, array $ids): int
    {
        if ($ids === []) {
            return 0;
        }

        return $this->db()->table($table)
            ->whereIn($column, $ids)
            ->countAllResults();
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
