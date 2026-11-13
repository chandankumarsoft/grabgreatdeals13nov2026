<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendProductModel;
use App\Models\Backend\BackendReviewModel;
use CodeIgniter\HTTP\ResponseInterface;

class ReviewAdmin extends AdminBaseController
{
    public function product_review(string $productId): ResponseInterface|string
    {
        $id = $this->positiveId($productId);
        if ($id === null || (new BackendProductModel())->product($id) === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        return $this->renderAdminPage('review/review_list', [
            'all_review' => (new BackendReviewModel())->reviewsForProduct($id),
        ]);
    }

    public function product_review_update(): ResponseInterface
    {
        $productId = $this->positiveId($this->request->getPost('dataattrpro'));
        $reviewId = $this->positiveId($this->request->getPost('dataattr'));
        if ($productId === null || $reviewId === null) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid product review.']);
        }

        $showOnFrontend = (new BackendReviewModel())->toggleReview($reviewId, $productId);
        if ($showOnFrontend === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product review not found.']);
        }

        return $this->response->setJSON(['success' => $showOnFrontend]);
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }
}
