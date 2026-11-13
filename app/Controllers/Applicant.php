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
use CodeIgniter\HTTP\RedirectResponse;
use RuntimeException;

class Applicant extends BaseController
{
    public function index(): string
    {
        return $this->renderPage();
    }

    public function applicant_submit(): string|RedirectResponse
    {
        $validation = service('validation');
        $validation->setRules([
            'applicant_full_name'    => 'required',
            'applicant_email'        => 'required|valid_email',
            'applicant_phone'        => 'required',
            'applicant_company_name' => 'required',
            'applicant_message'      => 'required',
            'applicant_country'      => 'required',
            'applicant_state'        => 'required',
            'applicant_city'         => 'required',
            'applicant_address'      => 'required',
            'applicant_zip'          => 'required',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->renderPage();
        }

        $fields = [
            'applicant_full_name',
            'applicant_email',
            'applicant_phone',
            'applicant_company_name',
            'applicant_abn',
            'applicant_message',
            'applicant_country',
            'applicant_state',
            'applicant_city',
            'applicant_address',
            'applicant_zip',
        ];
        $applicant = [];

        foreach ($fields as $field) {
            $applicant[$field] = $this->request->getPost($field);
        }

        if (! db_connect()->table('tbl_applicant')->insert($applicant)) {
            throw new RuntimeException('Unable to save the applicant details.');
        }

        service('session')->setFlashdata('success', 'Your Data Received Successfully');

        return redirect()->to(site_url('applicants'));
    }

    private function renderPage(): string
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
        $data = ['page' => 'applicants_page'];
        $output = '';

        foreach ([
            ['front/header', $data],
            ['front/category', []],
            ['front/breadcrumbs', []],
            ['front/applicants_page', []],
            ['front/footer', []],
        ] as [$view, $viewData]) {
            $output .= $renderer->render($view, $viewData);
        }

        return $output;
    }
}
