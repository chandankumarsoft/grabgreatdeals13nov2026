<?php

namespace App\Controllers\Backend;

use App\Libraries\LegacyPaginationAdapter;
use App\Models\Backend\BackendProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductCatalog extends AdminBaseController
{
    public function filterdata_by_product_name(): ResponseInterface|string
    {
        if (! $this->canViewBackendProducts()) {
            return $this->response->setStatusCode(403)->setBody('You are not authorized to view products.');
        }

        $name = $this->request->getPost('filter_data_name_value');
        if (! is_scalar($name) || trim((string) $name) === '') {
            $name = $this->request->getGet('filter_data_name_value');
        }
        if (! is_scalar($name) || trim((string) $name) === '') {
            return $this->response->setStatusCode(400)->setBody('Enter a product name to search.');
        }
        $name = trim((string) $name);

        $offset = $this->pageOffset();
        $query = http_build_query(['filter_data_name_value' => $name]);
        $model = new BackendProductModel();
        $total = $model->countBackendProductsByName($name);

        return $this->renderAdminPage('product_list', [
            'all_product' => $model->backendProductsByName($name, 10, $offset),
            'total_rows' => $total,
            'links' => (new LegacyPaginationAdapter(
                admin_url('search_by_product_name?' . $query),
                $total,
                10,
                $offset,
            ))->create_links(),
        ]);
    }

    public function show_product_list(): ResponseInterface|string
    {
        if (! $this->canViewBackendProducts()) {
            return $this->response->setStatusCode(403)->setBody('You are not authorized to view products.');
        }

        $offset = $this->pageOffset();
        $model = new BackendProductModel();
        $total = $model->countBackendProducts();

        return $this->renderAdminPage('product_list', [
            'all_product' => $model->backendProducts([], 10, $offset),
            'total_rows' => $total,
            'links' => (new LegacyPaginationAdapter(admin_url('product-list'), $total, 10, $offset))->create_links(),
        ]);
    }

    public function filter_backend_product_details(): ResponseInterface|string
    {
        if (! $this->canViewBackendProducts()) {
            return $this->response->setStatusCode(403)->setBody('You are not authorized to view products.');
        }

        $filters = [];
        foreach ([
            'category_name',
            'product_type_name',
            'tag_name',
            'search_keyword_name',
            'brand_name',
            'color_name',
            'size_name',
            'pro_status',
            'pro_availability',
        ] as $field) {
            $value = $this->request->getGet($field);
            if (is_scalar($value)) {
                $filters[$field] = trim((string) $value);
            }
        }

        $offset = $this->pageOffset();
        $model = new BackendProductModel();
        $total = $model->countBackendProducts($filters);
        $query = http_build_query(array_filter($filters, static fn (string $value): bool => $value !== ''));
        $url = admin_url('search_filter_backend') . ($query === '' ? '' : '?' . $query);

        return $this->renderAdminPage('product_list', [
            'all_product' => $model->backendProducts($filters, 10, $offset),
            'total_rows' => $total,
            'links' => (new LegacyPaginationAdapter($url, $total, 10, $offset))->create_links(),
        ]);
    }

    private function canViewBackendProducts(): bool
    {
        return in_array((int) service('session')->get('userrole'), [1, 5], true);
    }

    private function pageOffset(): int
    {
        $page = $this->request->getGet('page');

        return is_scalar($page) && ctype_digit((string) $page) ? (int) $page : 0;
    }
}
