<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;
use RuntimeException;

final class BackendReviewModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    /**
     * @return list<object>
     */
    public function reviewsForProduct(int $productId): array
    {
        return $this->db()->table('tbl_product_review')
            ->where('product_id', $productId)
            ->orderBy('review_id', 'DESC')
            ->get()
            ->getResult();
    }

    public function toggleReview(int $reviewId, int $productId): ?int
    {
        $database = $this->db();
        $review = $database->table('tbl_product_review')
            ->select('show_frontend')
            ->where('review_id', $reviewId)
            ->where('product_id', $productId)
            ->get()
            ->getRow();

        if ($review === null) {
            return null;
        }

        $showOnFrontend = (int) $review->show_frontend === 1 ? 0 : 1;
        if (! $database->table('tbl_product_review')
            ->where('review_id', $reviewId)
            ->where('product_id', $productId)
            ->update(['show_frontend' => $showOnFrontend])) {
            throw new RuntimeException('Unable to update the product review status.');
        }

        return $showOnFrontend;
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
