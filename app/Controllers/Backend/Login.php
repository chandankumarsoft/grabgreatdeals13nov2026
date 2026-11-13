<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\LegacyViewRenderer;
use App\Models\Backend\AdminLoginModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Login extends BaseController
{
    public function index(): ResponseInterface|string
    {
        helper('url');
        $session = service('session');
        if (is_numeric($session->get('userid')) && (int) $session->get('userstatus') === 1) {
            return redirect()->to(base_url('admin'));
        }

        return $this->renderBackendView('login');
    }

    public function checklogin(): ResponseInterface|string
    {
        helper('url');
        $email = trim((string) $this->request->getPost('user_email'));
        $password = $this->request->getPost('user_password');
        $user = $email === '' ? null : (new AdminLoginModel())->findUserByEmail($email);

        if (
            ! is_string($password)
            || $user === null
            || ! is_string($user->user_password ?? null)
            || ! password_verify($password, $user->user_password)
        ) {
            return $this->renderBackendView('login', [
                'error_message' => 'Incorrect Username Or Password...!',
            ]);
        }

        if ((int) ($user->user_status ?? 0) !== 1) {
            return $this->renderBackendView('login', [
                'error_message' => 'U Are Not An Active User...!',
            ]);
        }

        $session = service('session');
        $session->regenerate(true);
        $session->set([
            'userid'     => (int) $user->user_id,
            'username'   => (string) $user->username,
            'useremail'  => (string) $user->user_email,
            'userrole'   => (int) $user->user_role,
            'userstatus' => (int) $user->user_status,
        ]);

        return redirect()->to(base_url('admin'));
    }

    public function login_error(): string
    {
        return $this->renderBackendView('login', [
            'error_message' => 'Incorrect Username Or Password...!',
        ]);
    }

    public function adminlogout(): ResponseInterface|string
    {
        helper('url');
        service('session')->destroy();

        return $this->renderBackendView('login', [
            'success_message' => 'Successfully Logout...!',
        ]);
    }

    public function admin_signup(): ResponseInterface|string
    {
        helper('form');
        $data = [];

        if (strtoupper($this->request->getMethod()) === 'POST') {
            $validation = service('validation');
            $validation->setRules([
                'name'      => 'required|min_length[3]|max_length[255]',
                'email'     => 'required|valid_email|max_length[255]',
                'mobile'    => 'required|max_length[50]',
                'password'  => 'required|min_length[6]',
                'adminrole' => 'required|in_list[video editor]',
            ]);

            if ($validation->run($this->request->getPost())) {
                $pendingAdmin = [
                    'name'      => trim((string) $this->request->getPost('name')),
                    'email'     => trim((string) $this->request->getPost('email')),
                    'mobile'    => trim((string) $this->request->getPost('mobile')),
                    'adminrole' => (string) $this->request->getPost('adminrole'),
                    'password'  => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
                ];
                $model = new AdminLoginModel();

                if ($model->pendingAdminExists($pendingAdmin)) {
                    $data['error_message'] = 'An application with this email or mobile number already exists.';
                } elseif (! $model->createPendingAdmin($pendingAdmin)) {
                    throw new RuntimeException('Unable to save the admin signup application.');
                } else {
                    $data['success_message'] = 'Record Added Successfully Wait for Approval';
                }
            }
        }

        return $this->renderBackendView('adminsignup', $data);
    }

    private function renderBackendView(string $view, array $data = []): string
    {
        helper('form');
        helper('legacy_storefront');

        return (new LegacyViewRenderer('backend'))->render($view, $data);
    }
}
