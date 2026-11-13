<?php

namespace App\Controllers;

use App\Libraries\WebpImage;
use App\Libraries\LegacyCartAdapter;
use App\Libraries\CustomerPassword;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use App\Models\LegacyProfileModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class Profile extends BaseController
{
    public function index(): string|RedirectResponse
    {
        return $this->renderProfilePage('profile_page', 'profile');
    }

    public function order_list(): string|RedirectResponse
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }

        return $this->renderProfilePage('order_list', 'orderlist', [
            'order_data' => (new LegacyProfileModel())->get_all_order($customerId),
        ]);
    }

    public function order_list_by_id(string $orderId): string|RedirectResponse|ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }
        if (! ctype_digit($orderId)) {
            return $this->response->setStatusCode(404)->setBody('Order not found.');
        }

        $model = new LegacyProfileModel();
        $order = $model->get_all_order_order_id($customerId, $orderId);
        if ($order === null) {
            return $this->response->setStatusCode(404)->setBody('Order not found.');
        }
        $billing = $model->get_billing_details_order_by_id($customerId, $orderId);
        $shipping = $model->get_shipping_details_order_by_id($customerId, $orderId);
        if ($billing === null || $shipping === null) {
            return $this->response->setStatusCode(404)->setBody('Order address details not found.');
        }

        return $this->renderProfilePage('order_list_by_id', 'orderlist', [
            'order_data_details' => $order,
            'order_data_value'   => $order,
            'bill_info'          => $billing,
            'ship_info'          => $shipping,
            'order_details_info' => $model->get_order_details($orderId),
        ]);
    }

    public function order_status(): string|RedirectResponse
    {
        return $this->renderProfilePage('order_status', 'profile');
    }

    public function upload_order(): string|RedirectResponse
    {
        return $this->renderProfilePage('upload_order', 'profile');
    }

    public function profile_shopping_cart(): string|RedirectResponse
    {
        return $this->renderProfilePage('profile_shopping_cart', 'profile');
    }

    public function recently_view(): string|RedirectResponse
    {
        return $this->renderProfilePage('recently_view', 'profile');
    }

    public function address_list(): string|RedirectResponse
    {
        return $this->renderProfilePage('my_address_page', 'profile');
    }

    public function edit_address_list(): string|RedirectResponse
    {
        return $this->renderProfilePage('address_list', 'profile');
    }

    public function update_address(): string|RedirectResponse|ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }

        if ($this->request->getPost('cus_address') === null) {
            return $this->renderProfilePage('address_list', 'profile');
        }

        $updated = db_connect()->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->update([
                'cus_city'    => trim((string) $this->request->getPost('cus_city')),
                'cus_address' => trim((string) $this->request->getPost('cus_address')),
                'cus_zip'     => trim((string) $this->request->getPost('cus_zip')),
            ]);
        if (! $updated) {
            throw new RuntimeException('Unable to update the customer address.');
        }

        return redirect()->back();
    }

    public function favorite_details(): string|RedirectResponse
    {
        return $this->wishlist_list();
    }

    public function my_credits(): string|RedirectResponse
    {
        return $this->renderProfilePage('my_credits_page', 'profile');
    }

    public function my_coupon(): string|RedirectResponse
    {
        return $this->renderProfilePage('coupon_code_page', 'profile');
    }

    public function my_profile(): string|RedirectResponse
    {
        return $this->renderProfilePage('my_profile_page', 'profile');
    }

    public function edit_my_profile(): string|RedirectResponse
    {
        return $this->renderProfilePage('edit_profile_page', 'profile');
    }

    public function update_profile(): string|RedirectResponse|ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }

        if (! $this->request->getPost('cus_email')) {
            return $this->renderProfilePage('edit_profile_page', 'profile');
        }

        $validation = service('validation');
        $validation->setRules([
            'cus_name'   => 'required|max_length[100]',
            'cus_email'  => 'required|valid_email|max_length[100]',
            'cus_mobile' => 'permit_empty|max_length[14]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return $this->response->setStatusCode(422)->setJSON([
                'errors' => $validation->getErrors(),
            ]);
        }

        $database = db_connect();
        $emailOwner = $database->table('tbl_customer')
            ->where('cus_email', trim((string) $this->request->getPost('cus_email')))
            ->where('cus_id !=', $customerId)
            ->countAllResults();
        if ($emailOwner > 0) {
            service('session')->setFlashdata('error_message', 'Email Id Already Exists');

            return redirect()->back();
        }

        $updated = $database->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->update([
                'cus_name'   => trim((string) $this->request->getPost('cus_name')),
                'cus_email'  => trim((string) $this->request->getPost('cus_email')),
                'cus_mobile' => trim((string) $this->request->getPost('cus_mobile')),
            ]);
        if (! $updated) {
            throw new RuntimeException('Unable to update the customer profile.');
        }

        service('session')->set([
            'cus_name'  => trim((string) $this->request->getPost('cus_name')),
            'cus_email' => trim((string) $this->request->getPost('cus_email')),
        ]);

        return redirect()->back();
    }

    public function change_account_password(): string|RedirectResponse|ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }

        $newPassword = (string) $this->request->getPost('cus_password_new');
        if ($this->request->getPost('cus_password') === null) {
            return $this->renderProfilePage('change_password', 'profile');
        }

        $validation = service('validation');
        $validation->setRules([
            'cus_password'             => 'required',
            'cus_password_new'         => 'required|min_length[6]',
            'cus_password_new_confirm' => 'required|matches[cus_password_new]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            service('session')->setFlashdata('error_message', implode(' ', $validation->getErrors()));

            return redirect()->back();
        }

        $database = db_connect();
        $customer = $database->table('tbl_customer')
            ->select('cus_password')
            ->where('cus_id', $customerId)
            ->get()
            ->getRow();

        $currentPassword = (string) $this->request->getPost('cus_password');
        if ($customer === null || ! CustomerPassword::verify($currentPassword, (string) $customer->cus_password)) {
            service('session')->setFlashdata('error_message', 'New password not match with current password');

            return redirect()->back();
        }

        if (! $database->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->update(['cus_password' => CustomerPassword::hash($newPassword)])) {
            throw new RuntimeException('Unable to update the customer password.');
        }

        service('session')->setFlashdata('error_message', 'Password Changes sucesfully');

        return redirect()->back();
    }

    public function news_letter(): string|RedirectResponse
    {
        return $this->renderProfilePage('news_letter_profile', 'profile');
    }

    public function news_letter_status(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[tbl_news_letter.email]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->response->setJSON([
                'error_msg_validation' => '<p>' . esc($validation->getError('email')) . '</p>',
            ]);
        }

        if (! db_connect()->table('tbl_news_letter')->insert([
            'email'       => trim((string) $this->request->getPost('email')),
            'news_letter' => trim((string) $this->request->getPost('news_letter_status')),
        ])) {
            throw new RuntimeException('Unable to save the newsletter preference.');
        }

        return $this->response->setJSON(['error_msg' => 'success']);
    }

    public function profile_news_letter_status(): RedirectResponse
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }

        $status = $this->request->getPost('news_letter');
        if (! in_array((string) $status, ['0', '1'], true)) {
            return redirect()->back();
        }

        $database = db_connect();
        $email = (string) service('session')->get('cus_email');
        $existing = $database->table('tbl_news_letter')
            ->where('email', $email)
            ->get()
            ->getRow();

        if ($existing === null) {
            if (! $database->table('tbl_news_letter')->insert([
                'cus_id'      => $customerId,
                'email'       => $email,
                'news_letter' => $status,
            ])) {
                throw new RuntimeException('Unable to save the newsletter preference.');
            }
        } elseif (! $database->table('tbl_news_letter')
            ->where('email', $email)
            ->update(['news_letter' => $status])) {
            throw new RuntimeException('Unable to update the newsletter preference.');
        }

        return redirect()->back();
    }

    public function my_reviews(): string|RedirectResponse
    {
        return $this->renderProfilePage('my_reviews', 'profile');
    }

    public function add_product_seller(): string|RedirectResponse
    {
        return $this->renderProfilePage('add_product_seller_view', 'profile');
    }

    public function add_reviews(): ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Please sign in to add a review.']);
        }

        $validation = service('validation');
        $validation->setRules([
            'product_id'         => 'required|is_natural_no_zero',
            'rating_val'         => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'reviewer_name'      => 'required|max_length[100]',
            'review_title'       => 'required|max_length[255]',
            'review_description' => 'required',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return $this->response->setStatusCode(422)->setJSON(['errors' => $validation->getErrors()]);
        }

        $database = db_connect();
        $productId = (int) $this->request->getPost('product_id');
        if (! $database->table('tbl_product')->where('pro_id', $productId)->countAllResults()) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product not found.']);
        }

        $imageName = '';
        $image = $this->request->getFile('review_image');
        if ($image instanceof UploadedFile && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $imageName = $this->storeImage($image, 'review');
        }

        if (! $database->table('tbl_product_review')->insert([
            'product_id'         => $productId,
            'customer_id'        => $customerId,
            'review_price'       => (int) $this->request->getPost('rating_val'),
            'review_value'       => (int) $this->request->getPost('rating_val'),
            'review_quality'     => (int) $this->request->getPost('rating_val'),
            'review_average'     => (int) $this->request->getPost('rating_val'),
            'reviewer_name'      => trim((string) $this->request->getPost('reviewer_name')),
            'review_title'       => trim((string) $this->request->getPost('review_title')),
            'review_description' => trim((string) $this->request->getPost('review_description')),
            'review_image'       => $imageName,
        ])) {
            throw new RuntimeException('Unable to save the product review.');
        }

        $average = $database->table('tbl_product_review')
            ->selectAvg('review_value', 'avg_review_value')
            ->where('product_id', $productId)
            ->get()
            ->getRow();
        if ($average !== null) {
            $database->table('tbl_product')
                ->where('pro_id', $productId)
                ->update(['review_average' => $average->avg_review_value]);
        }

        return $this->response->setJSON(['success' => 'success']);
    }

    public function add_wishlist(): ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return $this->response->setJSON(['cus_status' => 'not_log_in']);
        }

        $productId = $this->request->getPost('wishlist_pro_id');
        if (! is_scalar($productId) || ! ctype_digit((string) $productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid product.']);
        }

        $database = db_connect();
        if (! $database->table('tbl_product')->where('pro_id', $productId)->countAllResults()) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product not found.']);
        }
        $exists = $database->table('tbl_wishlist')
            ->where('wishlist_pro_id', $productId)
            ->where('wishlist_cus_id', $customerId)
            ->countAllResults();
        if ($exists > 0) {
            return $this->response->setJSON(['wishlist_already_register' => 'already_registered']);
        }

        if (! $database->table('tbl_wishlist')->insert([
            'wishlist_pro_id' => $productId,
            'wishlist_cus_id' => $customerId,
        ])) {
            throw new RuntimeException('Unable to add this product to the wishlist.');
        }

        return $this->response->setJSON(['wishlist_added' => 'success']);
    }

    public function wishlist_list(): string|RedirectResponse
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return redirect()->to(site_url('register'));
        }

        return $this->renderProfilePage('wishlist', 'wishlist', [
            'wishlist' => (new LegacyProfileModel())->get_wishlist($customerId),
        ]);
    }

    public function delete_wishlist_list(): ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return $this->response->setJSON(['wishlist_delete_status' => 'failed']);
        }

        $productId = $this->request->getPost('wishlist_delete_pro_id');
        if (! is_scalar($productId) || ! ctype_digit((string) $productId)) {
            return $this->response->setStatusCode(400)->setJSON(['wishlist_delete_status' => 'failed']);
        }

        $deleted = db_connect()->table('tbl_wishlist')
            ->where('wishlist_pro_id', $productId)
            ->where('wishlist_cus_id', $customerId)
            ->delete();

        return $this->response->setJSON([
            'wishlist_delete_status' => $deleted ? 'success' : 'failed',
        ]);
    }

    public function updateProfileImage(): ResponseInterface
    {
        $customerId = $this->customerId();
        if ($customerId === null) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Please sign in first.']);
        }

        $image = $this->request->getFile('profile_image');
        if (! $image instanceof UploadedFile || $image->getError() !== UPLOAD_ERR_OK) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Select an image to upload.']);
        }

        $imageName = $this->storeImage($image, 'profile');
        if (! db_connect()->table('tbl_customer')
            ->where('cus_id', $customerId)
            ->update(['profile_image' => $imageName])) {
            throw new RuntimeException('Unable to save the profile image.');
        }

        return $this->response->setJSON(['message' => 'success', 'image' => $imageName]);
    }

    private function renderProfilePage(
        string $view,
        string $page,
        array $data = [],
    ): string|RedirectResponse {
        if ($this->customerId() === null) {
            return redirect()->to(site_url('register'));
        }

        helper('legacy_storefront');
        $session = new LegacySessionAdapter(service('session'));
        $services = [
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'ProfileModel'  => new LegacyProfileModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ];
        $renderer = new LegacyViewRenderer('frontend', $services);
        $data['page'] = $page;
        $output = '';

        foreach ([
            ['front/header', $data],
            ['front/category', []],
            ['front/breadcrumbs', []],
            ['profile/' . $view, $data],
            ['front/footer', []],
        ] as [$viewName, $viewData]) {
            $output .= $renderer->render($viewName, $viewData);
        }

        return $output;
    }

    private function customerId(): int|string|null
    {
        $customerId = service('session')->get('cus_id');

        return is_numeric($customerId) && (int) $customerId > 0 ? $customerId : null;
    }

    private function storeImage(UploadedFile $image, string $subdirectory): string
    {
        if (
            ! $image->isValid()
            || $image->getSize() > 5_000_000
            || ! in_array(strtolower($image->getExtension()), ['jpg', 'jpeg', 'png', 'gif'], true)
            || ! in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'], true)
        ) {
            throw new RuntimeException('The uploaded image is invalid or has an unsupported type.');
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $subdirectory;
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the image upload directory.');
        }

        $name = WebpImage::filename($image, $image->getRandomName());
        WebpImage::store($image, $directory, $name);

        return $name;
    }
}
