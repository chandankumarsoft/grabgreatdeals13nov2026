<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

final class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');
        $userId = $session->get('userid');
        $userStatus = $session->get('userstatus');

        if (is_numeric($userId) && (int) $userId > 0 && (int) $userStatus === 1) {
            return null;
        }

        helper('url');

        return redirect()->to(base_url('admin/login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
