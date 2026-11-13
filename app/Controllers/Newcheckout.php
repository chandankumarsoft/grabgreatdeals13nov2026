<?php

namespace App\Controllers;

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
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Newcheckout extends BaseController
{
    public function shipping_contact(): string
    {
        $customer = $this->currentCustomer();

        return $this->renderPage('front/newcheckout/checkoutcontact', [
            'page'             => 'checkout_page',
            'fetched_cus_info' => $customer,
        ]);
    }

    public function shipping_save(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'account_email'        => 'required|valid_email',
            'shipping_first_name'  => 'required|max_length[255]',
            'shipping_last_name'   => 'required|max_length[255]',
            'shipping_address1'    => 'required',
            'shipping_city'        => 'required|max_length[255]',
            'shipping_country'     => 'required|max_length[100]',
            'shipping_state'       => 'required|max_length[100]',
            'shipping_postal_code' => 'required|max_length[100]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();
            $response = [];
            foreach ([
                'account_email',
                'shipping_first_name',
                'shipping_last_name',
                'shipping_address1',
                'shipping_city',
                'shipping_country',
                'shipping_state',
                'shipping_postal_code',
            ] as $field) {
                $response[$field . '_error'] = isset($errors[$field])
                    ? '<p>' . esc($errors[$field]) . '</p>'
                    : '';
            }

            return $this->response->setJSON($response);
        }

        $email = trim((string) $this->request->getPost('account_email'));
        $database = db_connect();
        $customer = $database->table('tbl_customer')
            ->select('cus_id, cus_email')
            ->where('cus_email', $email)
            ->get()
            ->getRow();

        if ($customer === null) {
            $inserted = $database->table('tbl_customer')->insert([
                'cus_email'    => $email,
                'cus_password' => CustomerPassword::hash(bin2hex(random_bytes(24))),
            ]);
            if (! $inserted) {
                throw new RuntimeException('Unable to create the checkout customer record.');
            }

            $customerId = $database->insertID();
        } else {
            $customerId = (int) $customer->cus_id;
        }

        $session = service('session');
        $session->set([
            'account_email' => $email,
            'shipping_first_name' => trim((string) $this->request->getPost('shipping_first_name')),
            'shipping_last_name' => trim((string) $this->request->getPost('shipping_last_name')),
            'shipping_mobile_number' => trim((string) $this->request->getPost('shipping_mobile_number')),
            'shipping_company_name' => trim((string) $this->request->getPost('shipping_company_name')),
            'shipping_address1' => trim((string) $this->request->getPost('shipping_address1')),
            'shipping_address2' => trim((string) $this->request->getPost('shipping_address2')),
            'shipping_city' => trim((string) $this->request->getPost('shipping_city')),
            'shipping_country' => trim((string) $this->request->getPost('shipping_country')),
            'shipping_state' => trim((string) $this->request->getPost('shipping_state')),
            'shipping_postal_code' => trim((string) $this->request->getPost('shipping_postal_code')),
        ]);
        if ((int) $session->get('cus_id') !== $customerId || (string) $session->get('cus_email') !== $email) {
            $session->remove(['cus_id', 'cus_name', 'cus_email']);
        }

        return $this->response->setJSON([
            'status'                     => 'ok',
            'account_email_error'        => '',
            'shipping_first_name_error'  => '',
            'shipping_last_name_error'   => '',
            'shipping_address1_error'    => '',
            'shipping_city_error'        => '',
            'shipping_country_error'     => '',
            'shipping_state_error'       => '',
            'shipping_postal_code_error' => '',
        ]);
    }

    public function billing(): string
    {
        return $this->renderPage('front/newcheckout/checkoutbilling', [
            'page' => 'checkout_page',
        ]);
    }

    public function billing_save(): ResponseInterface
    {
        $session = service('session');
        $session->set([
            'billing_type' => $this->request->getPost('billing_type'),
            'billing_first_name' => trim((string) $this->request->getPost('billing_first_name')),
            'billing_last_name' => trim((string) $this->request->getPost('billing_last_name')),
            'billing_mobile_number' => trim((string) $this->request->getPost('billing_mobile_number')),
            'billing_company_name' => trim((string) $this->request->getPost('billing_company_name')),
            'billing_address1' => trim((string) $this->request->getPost('billing_address1')),
            'billing_address2' => trim((string) $this->request->getPost('billing_address2')),
            'billing_city' => trim((string) $this->request->getPost('billing_city')),
            'billing_country' => trim((string) $this->request->getPost('billing_country')),
            'billing_state' => trim((string) $this->request->getPost('billing_state')),
            'billing_postal_code' => trim((string) $this->request->getPost('billing_postal_code')),
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }

    public function payment(): string
    {
        return $this->renderPage('front/newcheckout/checkoutpayment', [
            'page' => 'checkout_page',
        ]);
    }

    private function currentCustomer(): object
    {
        $customerId = service('session')->get('cus_id');
        if (is_numeric($customerId)) {
            $customer = db_connect()->table('tbl_customer')
                ->where('cus_id', $customerId)
                ->get()
                ->getRow();
            if ($customer !== null) {
                return $customer;
            }
        }

        return (object) ['cus_country' => null];
    }

    /**
     * @param array<string, mixed> $data
     */
    private function renderPage(string $contentView, array $data): string
    {
        helper('legacy_storefront');
        $session = new LegacySessionAdapter(service('session'));
        $renderer = new LegacyViewRenderer('frontend', [
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ]);
        $output = '';

        foreach ([
            ['front/header', $data],
            ['front/category', []],
            [$contentView, $data],
            ['front/footer', []],
        ] as [$view, $viewData]) {
            $output .= $renderer->render($view, $viewData);
        }

        return $output;
    }
}
