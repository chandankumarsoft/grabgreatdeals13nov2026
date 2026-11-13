<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use App\Models\LegacySearchModel;
use CodeIgniter\HTTP\ResponseInterface;

class Search extends BaseController
{
    public function index(): string
    {
        helper('legacy_storefront');
        $keyword = trim((string) $this->request->getPost('search'));
        service('session')->set('searchData', 'ok');

        $searchModel = new LegacySearchModel();
        $categoryIds = $searchModel->getCategoryIdsByName($keyword);
        $products = $searchModel->getSearchProducts($keyword, $categoryIds);
        $data = [
            'page'                   => 'shop',
            'category'               => (new LegacyCategoryModel())->getRootCategoriesWithProductCounts(),
            'price'                  => (new LegacyProductModel())->getPriceRange(),
            'allproduct'             => $products,
            'counted_product_no'     => count($products),
            'page_number_breadcrumb' => 0,
        ];

        return $this->renderPage('front/shop_list', $data);
    }

    public function filterdata(): string|ResponseInterface
    {
        helper('legacy_storefront');
        $filters = [
            'categories'   => $this->arrayPost('category_data'),
            'minimum'      => $this->request->getPost('minvalue'),
            'maximum'      => $this->request->getPost('maxvalue'),
            'sort'         => $this->request->getPost('filter_sort_by_value'),
            'colors'       => $this->arrayPost('colorDataValueByClass'),
            'sizes'        => $this->arrayPost('sizeDataValueByClass'),
            'brands'       => $this->arrayPost('brandDataValueByClass'),
            'ratings'      => $this->arrayPost('ratingDataValueByClass'),
            'arrival_days' => $this->arrayPost('newAarrivalDataValueByClass'),
            'tags'         => $this->arrayPost('tagDataValueByClass'),
        ];
        $queryPage = $this->request->getGet('page');
        $offset = is_scalar($queryPage) && ctype_digit((string) $queryPage)
            ? (int) $queryPage
            : 0;
        $model = new LegacySearchModel();
        $total = $model->countFilteredProducts($filters);
        $data = [
            'page'                   => 'shop',
            'category'               => (new LegacyCategoryModel())->getRootCategoriesWithProductCounts(),
            'allproduct'             => $model->filterProducts($filters, 10, $offset),
            'counted_product_no'     => $total,
            'page_number_breadcrumb' => $offset,
            'pagination'             => new LegacyPaginationAdapter(
                base_url('search_filter'),
                $total,
                10,
                $offset,
            ),
        ];

        if ((string) $this->request->getPost('call_by_ajax') === '1') {
            $services = $this->legacyViewServices();
            $services['pagination'] = $data['pagination'];
            $renderer = new LegacyViewRenderer('frontend', $services);

            return $renderer->render('front/products_list', $data);
        }

        return $this->renderPage('front/shop_list', $data);
    }

    private function arrayPost(string $key): array
    {
        $value = $this->request->getPost($key);

        if (! is_array($value)) {
            return is_scalar($value) && (string) $value !== '' ? [(string) $value] : [];
        }

        return array_values(array_filter($value, 'is_scalar'));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function renderPage(string $contentView, array $data): string
    {
        $services = $this->legacyViewServices();
        if (isset($data['pagination']) && is_object($data['pagination'])) {
            $services['pagination'] = $data['pagination'];
        }
        $renderer = new LegacyViewRenderer('frontend', $services);
        $output = '';

        foreach ([
            ['front/header', ['page' => $data['page'] ?? 'shop']],
            ['front/category', []],
            ['front/breadcrumbs', []],
            [$contentView, $data],
            ['front/footer', []],
        ] as [$view, $viewData]) {
            $output .= $renderer->render($view, $viewData);
        }

        return $output;
    }

    /**
     * @return array<string, object>
     */
    private function legacyViewServices(): array
    {
        helper('legacy_storefront');
        $session = new LegacySessionAdapter(service('session'));

        return [
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ];
    }
}
