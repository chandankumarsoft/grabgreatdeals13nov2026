<?php

namespace App\Controllers\Backend;

use App\Models\Backend\AdminLoginModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Admin extends AdminBaseController
{
    public function index(): ResponseInterface
    {
        helper('url');

        return redirect()->to(base_url('admin'));
    }

    public function admindashboard(): string
    {
        helper('url');
        $database = db_connect();
        $sales = $database->table('tbl_order O')
            ->select('O.curreny_code, SUM(O.order_amount_withcurrency) AS amount')
            ->join('tbl_payment P', 'O.order_id = P.order_id', 'inner')
            ->where('P.payment_status', 2)
            ->groupBy('O.curreny_code')
            ->get()
            ->getResult();

        $dashboard = [
            'total_customer' => $database->table('tbl_customer')->countAllResults(),
            'total_order'    => $database->table('tbl_order')->countAllResults(),
            'new_order'      => $database->table('tbl_order O')
                ->join('tbl_payment P', 'O.order_id = P.order_id', 'inner')
                ->where('P.payment_status', 2)
                ->where('O.viewed_details', 0)
                ->countAllResults(),
            'total_order_currecy' => $sales,
        ];

        return $this->renderAdminPage('admin_main', $dashboard);
    }

    public function registerform(): ResponseInterface|string
    {
        if (! $this->isAdministrator()) {
            return $this->response->setStatusCode(403)->setBody('You are not authorized to manage admin users.');
        }

        helper('form');

        return $this->renderAdminPage('register_admin');
    }

    public function makeadmin(): ResponseInterface|string
    {
        if (! $this->isAdministrator()) {
            return $this->response->setStatusCode(403)->setBody('You are not authorized to manage admin users.');
        }

        helper('form');
        $validation = service('validation');
        $validation->setRules([
            'username'         => 'required|min_length[3]|max_length[255]',
            'user_email'       => 'required|valid_email|max_length[255]|is_unique[tbl_user.user_email]',
            'user_password'    => 'required|min_length[6]',
            'confirm_password' => 'required|matches[user_password]',
            'user_role'        => 'required|in_list[1,2,3,4,5,6]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage('register_admin');
        }

        $inserted = (new AdminLoginModel())->createUser([
            'username'     => trim((string) $this->request->getPost('username')),
            'user_email'   => trim((string) $this->request->getPost('user_email')),
            'user_password'=> password_hash((string) $this->request->getPost('user_password'), PASSWORD_DEFAULT),
            'user_role'    => (int) $this->request->getPost('user_role'),
            'user_status'  => 1,
        ]);

        if (! $inserted) {
            throw new RuntimeException('Unable to create the admin user.');
        }

        return $this->renderAdminPage('register_admin', [
            'success_message' => 'User Successfully Added',
        ]);
    }

    private function isAdministrator(): bool
    {
        return (int) service('session')->get('userrole') === 1;
    }

}
