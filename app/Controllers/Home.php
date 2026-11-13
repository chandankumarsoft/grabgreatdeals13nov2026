<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;

class Home extends BaseController
{
    public function index(): string
    {
        helper('legacy_storefront');

        $renderer = $this->legacyRenderer();

        $views = [
            ['front/header', ['page' => 'home']],
            ['front/category', []],
            ['front/slider', []],
            ['front/feature', []],
            ['front/recent_product', []],
            ['front/special', []],
            ['front/categoryarea', []],
            ['front/footer', []],
        ];

        $output = '';

        foreach ($views as [$view, $data]) {
            $output .= $renderer->render($view, $data);
        }

        return $output;
    }

    public function about_us(): string
    {
        return $this->renderPage('about', 'front/about_us');
    }

    public function contact_page(): string
    {
        return $this->renderPage('contact', 'front/contact_page');
    }

    public function insert_contact_info(): string|RedirectResponse
    {
        helper('url');

        $validation = service('validation');
        $validation->setRules([
            'contact_name'    => 'required',
            'contact_email'   => 'required|valid_email',
            'contact_subject' => 'required',
            'contact_message' => 'required',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->contact_page();
        }

        $contact = [
            'contact_name'    => $this->request->getPost('contact_name'),
            'contact_email'   => $this->request->getPost('contact_email'),
            'contact_subject' => $this->request->getPost('contact_subject'),
            'contact_message' => $this->request->getPost('contact_message'),
        ];

        if (! db_connect()->table('tbl_contact')->insert($contact)) {
            throw new \RuntimeException('Unable to save the contact message.');
        }

        service('session')->setFlashdata(
            'flash_msg',
            "<h3 class='alert alert-success text-center'>Message Send Successfully.</h3>",
        );

        return redirect()->to(site_url('contact-us'));
    }

    public function terms_of_use(): string
    {
        return $this->renderPage('terms-of-use', 'front/terms_of_use_page');
    }

    public function privacy_policy(): string
    {
        return $this->renderPage('privacy-policy', 'front/privacy_policy_page');
    }

    public function faq(): string
    {
        return $this->renderPage('faq', 'front/faq');
    }

    public function sitemap(): string
    {
        return $this->renderPage('sitemap', 'front/sitemap');
    }

    public function warranty_page(): string
    {
        return $this->renderPage('warranty_page', 'front/warrantyinformation_page');
    }

    public function shipping_policy(): string
    {
        return $this->renderPage('shipping-policy', 'front/shipping_policy_page');
    }

    public function return_page(): string
    {
        return $this->renderPage('return_page', 'front/returninfo_page');
    }

    public function complaints_page(): string
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $validation = service('validation');
            $validation->setRules([
                'complaint_name'     => 'required|min_length[3]',
                'complaint_email'    => 'required|valid_email',
                'complaint_subject'  => 'required',
                'complaint_message'  => 'required|min_length[10]',
                'complaint_customer' => 'required',
            ]);

            if (! $validation->run($this->request->getPost())) {
                return $this->renderPage('complaints_page', 'front/complaints_page');
            }

            $complaint = [
                'complaint_name'     => $this->request->getPost('complaint_name'),
                'complaint_email'    => $this->request->getPost('complaint_email'),
                'complaint_subject'  => $this->request->getPost('complaint_subject'),
                'complaint_message'  => $this->request->getPost('complaint_message'),
                'complaint_customer' => $this->request->getPost('complaint_customer'),
            ];

            if (! db_connect()->table('tbl_complaints')->insert($complaint)) {
                throw new \RuntimeException('Unable to save the complaint.');
            }

            service('session')->setFlashdata(
                'success_message',
                'your message has been submitted Successfully',
            );
        }

        return $this->renderPage('complaints_page', 'front/complaints_page');
    }

    public function delivery_page(): string
    {
        return $this->renderPage('delivery_page', 'front/delivery_page');
    }

    public function sustainability_page(): string
    {
        return $this->renderPage('sustainability_page', 'front/sustainability_page');
    }

    public function shop(): string
    {
        $products = new LegacyProductModel();
        $offset   = $this->pageOffset();
        $total    = $products->countShopProducts();
        $data     = [
            'page'                 => 'shop',
            'allproduct'           => $products->getShopProducts($offset),
            'counted_product_no'   => $total,
            'page_number_breadcrumb' => $offset,
            'category'             => (new LegacyCategoryModel())->getRootCategoriesWithProductCounts(),
            'price'                => $products->getPriceRange(),
        ];

        return $this->renderPage(
            'shop',
            'front/shop_list',
            $data,
            new LegacyPaginationAdapter(base_url('shop'), $total, 10, $offset),
        );
    }

    public function show_product_by_cat_id(string $categorySlug): string
    {
        if (! $this->isReadRequest()) {
            return $this->notFoundPage();
        }

        $categories = new LegacyCategoryModel();
        $category   = $categories->getCategoryBySlug($categorySlug);

        if ($category === null) {
            return $this->notFoundPage();
        }

        return $this->renderCategoryProducts($categories, $category->category_id, $categorySlug);
    }

    public function show_product_by_sub_cat_id(string $categorySlug, string $subCategorySlug): string
    {
        if (! $this->isReadRequest()) {
            return $this->notFoundPage();
        }

        $categories = new LegacyCategoryModel();
        $category   = $categories->getCategoryBySlug($categorySlug);
        $subCategory = $category === null
            ? null
            : $categories->getCategoryBySlug($subCategorySlug, $category->category_id);

        if ($category === null || $subCategory === null) {
            return $this->notFoundPage();
        }

        return $this->renderCategoryProducts(
            $categories,
            $subCategory->category_id,
            $categorySlug . '/' . $subCategorySlug,
        );
    }

    public function show_product_by_sub_sub_cat_id(
        string $categorySlug,
        string $subCategorySlug,
        string $subSubCategorySlug,
    ): string {
        if (! $this->isReadRequest()) {
            return $this->notFoundPage();
        }

        $categories  = new LegacyCategoryModel();
        $category    = $categories->getCategoryBySlug($categorySlug);
        $subCategory = $category === null
            ? null
            : $categories->getCategoryBySlug($subCategorySlug, $category->category_id);
        $subSubCategory = $subCategory === null
            ? null
            : $categories->getCategoryBySlug($subSubCategorySlug, $subCategory->category_id);

        if ($category === null || $subCategory === null || $subSubCategory === null) {
            return $this->notFoundPage();
        }

        return $this->renderCategoryProducts(
            $categories,
            $subSubCategory->category_id,
            $categorySlug . '/' . $subCategorySlug . '/' . $subSubCategorySlug,
        );
    }

    public function product_details(string $slug): string
    {
        $products    = new LegacyProductModel();
        $productInfo = $products->getProductBySlug($slug);

        if ($productInfo === null) {
            return $this->notFoundPage();
        }

        $categoryModel = new LegacyCategoryModel();
        $rootCategory  = empty($productInfo->pro_cat)
            ? null
            : $categoryModel->getRootCategoryId($productInfo->pro_cat);
        $categoryIds   = $rootCategory === null ? [] : $categoryModel->getDescendantIds($rootCategory);
        $data          = [
            'page'                    => 'product-details',
            'product_info'            => $productInfo,
            'gethotdealsfetch'        => $products->getRelatedProducts($categoryIds, $productInfo->pro_id),
            'gethotdealsfetchupsell'  => $products->get_hot_deals(),
        ];

        return $this->renderViews([
            ['front/header', ['page' => $data['page']]],
            ['front/category', []],
            ['front/shopbreadcrumbs', ['product_info' => $productInfo]],
            ['front/product_details', $data],
            ['front/footer', []],
        ]);
    }

    public function product_quick(string $slug): string
    {
        $productInfo = (new LegacyProductModel())->getProductBySlug($slug);

        if ($productInfo === null) {
            return $this->notFoundPage();
        }

        $data = ['page' => 'product-quick', 'product_info' => $productInfo];

        return $this->renderViews([
            ['front/header', ['page' => $data['page']]],
            ['front/category', []],
            ['front/slider', []],
            ['front/feature', []],
            ['front/special', []],
            ['front/categoryarea', []],
            ['front/quick_view', $data],
            ['front/footer', []],
        ]);
    }

    public function product_type(string $encodedType): string
    {
        $productType = base64_decode(urldecode($encodedType), true);

        if ($productType === false || preg_match('/\Ais_[a-z_]+\z/', $productType) !== 1) {
            return $this->notFoundPage();
        }

        $products = new LegacyProductModel();

        if ($products->getProductTypeName($productType) === null) {
            return $this->notFoundPage();
        }

        $data = [
            'page'               => 'product-type',
            'product_type'       => $products->getProductsByType($productType),
            'product_type_slug'  => $productType,
        ];

        return $this->renderViews([
            ['front/header', ['page' => $data['page']]],
            ['front/category', []],
            ['front/product_type', $data],
            ['front/footer', []],
        ]);
    }

    public function _404_page(): string
    {
        return $this->notFoundPage();
    }

    private function renderCategoryProducts(
        LegacyCategoryModel $categories,
        int|string $categoryId,
        string $path,
    ): string {
        $products   = new LegacyProductModel();
        $categoryIds = $categories->getDescendantIds($categoryId);
        $offset     = $this->pageOffset();
        $total      = $products->countProductsByCategory($categoryIds);
        $data       = [
            'page'                   => 'shop',
            'allproduct'             => $products->getProductsByCategory($categoryIds, $offset),
            'counted_product_no'     => $total,
            'page_number_breadcrumb' => $offset,
            'category'               => $categories->getRootCategoriesWithProductCounts(),
            'price'                  => $products->getPriceRange(),
        ];

        return $this->renderPage(
            'shop',
            'front/shop_list',
            $data,
            new LegacyPaginationAdapter(base_url($path), $total, 10, $offset),
        );
    }

    private function pageOffset(): int
    {
        $page = $this->request->getGet('page');

        return is_numeric($page) ? max(0, (int) $page) : 0;
    }

    private function isReadRequest(): bool
    {
        return in_array(strtolower($this->request->getMethod()), ['get', 'head'], true);
    }

    private function notFoundPage(): string
    {
        $this->response->setStatusCode(404);

        return $this->renderPage('404', 'front/404');
    }

    private function renderPage(
        string $page,
        string $contentView,
        array $data = [],
        ?LegacyPaginationAdapter $pagination = null,
    ): string {
        $data['page'] = $page;

        return $this->renderViews([
            ['front/header', $data],
            ['front/category', []],
            ['front/breadcrumbs', []],
            [$contentView, $data],
            ['front/footer', []],
        ], $pagination === null ? [] : ['pagination' => $pagination]);
    }

    /**
     * @param list<array{0: string, 1: array<string, mixed>}> $views
     * @param array<string, mixed> $services
     */
    private function renderViews(array $views, array $services = []): string
    {
        helper('legacy_storefront');

        $renderer = $this->legacyRenderer($services);
        $output   = '';

        foreach ($views as [$view, $data]) {
            $output .= $renderer->render($view, $data);
        }

        return $output;
    }

    /**
     * @param array<string, mixed> $extraServices
     */
    private function legacyRenderer(array $extraServices = []): LegacyViewRenderer
    {
        $session = new LegacySessionAdapter(service('session'));

        return new LegacyViewRenderer('frontend', array_replace([
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ], $extraServices));
    }
}
