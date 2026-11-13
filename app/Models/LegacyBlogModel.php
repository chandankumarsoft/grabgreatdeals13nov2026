<?php

namespace App\Models;

use CodeIgniter\Database\BaseConnection;

final class LegacyBlogModel
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = db_connect();
    }

    /**
     * @return list<object>
     */
    public function allGategoryOfBlog(): array
    {
        return $this->database->table('tbl_blog_category')
            ->select('blog_cat_name, blog_cat_slug, blog_cat_id')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function fetchallblogfront(int $perPage, int $offset): array
    {
        return $this->database->table('tbl_blog')
            ->where('status', '1')
            ->orderBy('blog_id', 'DESC')
            ->get($perPage, max(0, $offset))
            ->getResult();
    }

    public function countPublishedBlogs(): int
    {
        return $this->database->table('tbl_blog')
            ->where('status', '1')
            ->countAllResults();
    }

    public function publishedBlogExists(int $blogId): bool
    {
        return $this->database->table('tbl_blog')
            ->where('blog_id', $blogId)
            ->where('status', '1')
            ->countAllResults() > 0;
    }

    public function commentExists(int $blogId, int $commentId): bool
    {
        return $this->database->table('tbl_comment')
            ->where('comment_blog_id', $blogId)
            ->where('comment_id', $commentId)
            ->where('reply_comment_id', 0)
            ->countAllResults() > 0;
    }

    public function allCommentCount(int|string $blogId): object
    {
        return (object) [
            'countcommentid' => $this->database->table('tbl_comment')
                ->where('comment_blog_id', $blogId)
                ->countAllResults(),
        ];
    }

    /**
     * @return list<object>
     */
    public function relatedBlogData(string $slug): array
    {
        return $this->database->table('tbl_blog')
            ->like('slug', $slug)
            ->limit(7)
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function allTagsByBlog(int|string $blogId): array
    {
        return $this->database->table('tbl_blog_relation BR')
            ->select('BT.blog_tag_name, BT.blog_tag_slug')
            ->distinct()
            ->join('tbl_blog_tag BT', 'BR.blog_tag_id = BT.blog_tag_id')
            ->where('BR.blog_id', $blogId)
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function allTagsOfBlog(): array
    {
        return $this->database->table('tbl_blog_tag')
            ->select('blog_tag_name, blog_tag_slug, blog_tag_id')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function popularBlogPost(): array
    {
        return $this->recentBlogPost();
    }

    /**
     * @return list<object>
     */
    public function recentBlogPost(): array
    {
        return $this->database->table('tbl_blog')
            ->select('blog_id, title, slug, image, created_at')
            ->orderBy('blog_id', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();
    }

    public function blogDataBySlug(string $slug): ?object
    {
        $blog = $this->database->table('tbl_blog BT')
            ->select('BT.*, COUNT(BC.comment_id) AS countcommentid')
            ->join('tbl_comment BC', 'BT.blog_id = BC.comment_blog_id', 'left')
            ->where('BT.slug', $slug)
            ->where('BT.status', '1')
            ->groupBy('BT.blog_id')
            ->get()
            ->getRow();

        return $blog ?: null;
    }

    /**
     * @return list<object>
     */
    public function allBlogByCategory(int $perPage, int $offset): array
    {
        return $this->database->table('tbl_blog BG')
            ->select('BG.*')
            ->join('tbl_blog_relation BR', 'BG.blog_id = BR.blog_id')
            ->join('tbl_blog_category BC', 'BR.blog_cat_id = BC.blog_cat_id')
            ->groupBy('BG.blog_id')
            ->limit($perPage, max(0, $offset))
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function allBlogByCategorySlug(string $categorySlug): array
    {
        return $this->database->table('tbl_blog BG')
            ->select('BG.*')
            ->join('tbl_blog_relation BR', 'BR.blog_id = BG.blog_id')
            ->join('tbl_blog_category BC', 'BC.blog_cat_id = BR.blog_cat_id')
            ->where('BC.blog_cat_slug', $categorySlug)
            ->groupBy('BG.blog_id')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function allBlogTags(int $perPage, int $offset): array
    {
        return $this->database->table('tbl_blog BG')
            ->select('BG.*')
            ->join('tbl_blog_relation BR', 'BG.blog_id = BR.blog_id')
            ->join('tbl_blog_tag BT', 'BR.blog_tag_id = BT.blog_tag_id')
            ->groupBy('BG.blog_id')
            ->limit($perPage, max(0, $offset))
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function allBlogByTags(string $tagSlug): array
    {
        return $this->database->table('tbl_blog BG')
            ->select('BG.*')
            ->join('tbl_blog_relation BR', 'BR.blog_id = BG.blog_id')
            ->join('tbl_blog_tag BT', 'BT.blog_tag_id = BR.blog_tag_id')
            ->where('BT.blog_tag_slug', $tagSlug)
            ->groupBy('BG.blog_id')
            ->get()
            ->getResult();
    }

    public function insertComment(array $data): bool
    {
        return $this->database->table('tbl_comment')->insert(array_replace([
            'comment_like'       => 0,
            'comment_dislike'    => 0,
            'comment_subject'    => '',
            'comment_aaprove'    => '1',
            'user_id'            => 0,
            'comment_blog_id'    => 0,
            'reply_blog_comment_id' => 0,
            'reply_comment_id'   => 0,
        ], $data));
    }

    /**
     * @return list<object>
     */
    public function AllCommentedData(int|string $blogId): array
    {
        return $this->database->table('tbl_comment')
            ->where('comment_blog_id', $blogId)
            ->orderBy('comment_date', 'DESC')
            ->get()
            ->getResult();
    }

    /**
     * @return list<object>
     */
    public function AllCommentedDataReply(int|string $blogId, int|string $commentId): array
    {
        return $this->database->table('tbl_comment')
            ->where('reply_blog_comment_id', $blogId)
            ->where('reply_comment_id', $commentId)
            ->orderBy('comment_date', 'DESC')
            ->get()
            ->getResult();
    }

    public function insertLikeData(int|string $commentId, int|string $blogId, int $type): int
    {
        $column = $type === 1 ? 'comment_like' : 'comment_dislike';
        $updated = $this->database->table('tbl_comment')
            ->set($column, $column . ' + 1', false)
            ->where('comment_blog_id', $blogId)
            ->where('comment_id', $commentId)
            ->update();

        return $updated && $this->database->affectedRows() > 0 ? $type : 0;
    }

    public function insertBlogLikeData(int|string $blogId, int $type): int
    {
        $column = $type === 1 ? '`like`' : 'dislike';
        $updated = $this->database->table('tbl_blog')
            ->set($column, $column . ' + 1', false)
            ->where('blog_id', $blogId)
            ->update();

        return $updated && $this->database->affectedRows() > 0 ? $type : 0;
    }

    public function AllLikevalue(int|string $blogId): ?object
    {
        return $this->database->table('tbl_blog')
            ->select('`like`, dislike')
            ->where('blog_id', $blogId)
            ->get()
            ->getRow();
    }
}
