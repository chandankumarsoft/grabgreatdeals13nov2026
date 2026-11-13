<?php

namespace App\Controllers;

use App\Libraries\LegacyViewRenderer;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Coupon extends BaseController
{
    public function adds_form(): string
    {
        return (new LegacyViewRenderer('frontend'))->render('newsletter/freediscount');
    }

    public function discount_form_submit(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'free_discount_fname'  => 'required|max_length[100]',
            'free_discount_lname'  => 'required|max_length[100]',
            'free_discount_email'  => 'required|valid_email|max_length[255]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();

            return $this->response->setJSON([
                'free_discount_fname_error' => $this->formatError($errors, 'free_discount_fname'),
                'free_discount_lname_error' => $this->formatError($errors, 'free_discount_lname'),
                'free_discount_email_error' => $this->formatError($errors, 'free_discount_email'),
            ]);
        }

        $inserted = db_connect()->table('tbl_discount_email_list')->insert([
            'free_discount_fname' => trim(strip_tags((string) $this->request->getPost('free_discount_fname'))),
            'free_discount_lname' => trim(strip_tags((string) $this->request->getPost('free_discount_lname'))),
            'free_discount_email' => trim(strip_tags((string) $this->request->getPost('free_discount_email'))),
        ]);
        if (! $inserted) {
            throw new RuntimeException('Unable to save the discount registration.');
        }

        return $this->response->setJSON([
            'free_discount_fname_error' => '',
            'free_discount_lname_error' => '',
            'free_discount_email_error' => '',
            'data_submit_status'        => 'successfully added',
        ]);
    }

    private function formatError(array $errors, string $field): string
    {
        return isset($errors[$field]) ? '<p>' . esc($errors[$field]) . '</p>' : '';
    }
}
