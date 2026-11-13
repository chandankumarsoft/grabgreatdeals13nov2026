<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyCi3Encrypt;
use App\Libraries\CustomerPassword;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyInputAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacyRecoveryToken;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Customer extends BaseController
{
    public function sent_credentials(): ResponseInterface
    {
        if (! $this->validCronToken()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden.']);
        }

        $tokens = new LegacyRecoveryToken();

        $database = db_connect();
        $customers = $database->table('tbl_customer')
            ->select('cus_id, cus_email')
            ->where('credentials_sent', 0)
            ->get()
            ->getResult();
        $sent = 0;
        $failed = 0;
        $renderer = new LegacyViewRenderer('frontend');

        foreach ($customers as $customer) {
            $emailAddress = trim((string) $customer->cus_email);
            if (! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                log_message('error', 'Credential email skipped for customer {customerId}: invalid address.', [
                    'customerId' => $customer->cus_id,
                ]);
                $failed++;
                continue;
            }

            $resetToken = $tokens->encode('password_reset', $emailAddress, 86400);
            if ($resetToken === null) {
                return $this->response->setStatusCode(503)->setJSON([
                    'error' => 'Secure recovery links are not configured.',
                ]);
            }

            $message = $renderer->render('mailscripts/account_credentials', [
                'email'           => $emailAddress,
                'reset_url'       => base_url('reset-account-password-mail?reset=' . rawurlencode($resetToken)),
                'from'            => 'sales@grabgreatdeals.com.au',
                'admin_full_name' => 'grabgreatdeals.com',
                'to'              => $emailAddress,
                'subject'         => 'Account Credentials',
            ]);
            $email = service('email');
            $email->setFrom('sales@grabgreatdeals.com.au', 'grabgreatdeals.com');
            $email->setTo($emailAddress);
            $email->setSubject('Account Credentials');
            $email->setMessage($message);

            if (! $email->send()) {
                log_message('error', 'Credential email failed for customer {customerId}: {error}', [
                    'customerId' => $customer->cus_id,
                    'error'      => $email->printDebugger(['headers']),
                ]);
                $failed++;
                continue;
            }

            if (! $database->table('tbl_customer')->where('cus_id', $customer->cus_id)->update([
                'credentials_sent' => 1,
            ])) {
                log_message('error', 'Credential email sent but status update failed for customer {customerId}.', [
                    'customerId' => $customer->cus_id,
                ]);
                $failed++;
                continue;
            }

            $sent++;
        }

        return $this->response->setJSON(['sent' => $sent, 'failed' => $failed]);
    }

    public function resetAccountPasswordMail(): string
    {
        helper('legacy_storefront');
        $session = new LegacySessionAdapter(service('session'));
        $renderer = new LegacyViewRenderer('frontend', [
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'input'         => new LegacyInputAdapter($this->request),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ]);
        $data = ['reset' => false, 'page' => 'register'];
        $output = '';

        foreach ([
            ['front/header', $data],
            ['front/category', []],
            ['front/breadcrumbs', []],
            ['account/resetpasswordemailmail', []],
            ['front/footer', []],
        ] as [$view, $viewData]) {
            $output .= $renderer->render($view, $viewData);
        }

        return $output;
    }

    public function resetAccountPasswordMailUpdate(): ResponseInterface
    {
        $password = (string) $this->request->getPost('newPassword');
        $confirmation = (string) $this->request->getPost('confirmNewPassword');
        if ($password === '' || strlen($password) < 6 || $password !== $confirmation) {
            return $this->response->setStatusCode(400)->setJSON([
                'emailDataError' => 'Enter matching passwords with at least 6 characters.',
            ]);
        }

        $resetKey = $this->request->getPost('reset_key');
        $tokens = new LegacyRecoveryToken();
        $emailAddress = $tokens->decode($resetKey, 'password_reset');
        if ($emailAddress === null) {
            if (is_string($resetKey) && str_starts_with($resetKey, 'v2.')) {
                return $this->response->setStatusCode(400)->setJSON(['emailDataError' => 'Reset link is invalid or expired.']);
            }

            try {
                $emailAddress = (new LegacyCi3Encrypt())->decode($resetKey);
            } catch (RuntimeException $exception) {
                log_message('error', 'Legacy password reset is unavailable: {message}', [
                    'message' => $exception->getMessage(),
                ]);
                return $this->response->setStatusCode(503)->setJSON([
                    'emailDataError' => 'Password reset is temporarily unavailable.',
                ]);
            }
        }
        $emailAddress = trim($emailAddress ?? '');
        if (! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(400)->setJSON(['emailDataError' => 'Reset link is invalid.']);
        }

        $database = db_connect();
        $customer = $database->table('tbl_customer')
            ->select('cus_id')
            ->where('cus_email', $emailAddress)
            ->get()
            ->getRow();
        if ($customer === null) {
            return $this->response->setJSON(['emailDataError' => 'Email Not Exist']);
        }

        if (! $database->table('tbl_customer')->where('cus_id', $customer->cus_id)->update([
            'cus_password' => CustomerPassword::hash($password),
        ])) {
            throw new RuntimeException('Unable to update the customer password.');
        }

        return $this->response->setJSON(['emailDataSuccess' => 'Password Updated']);
    }

    private function validCronToken(): bool
    {
        $configuredToken = (string) env('jobs.cronToken', '');
        $requestToken = (string) $this->request->getHeaderLine('X-Cron-Token');

        return $configuredToken !== '' && $requestToken !== ''
            && hash_equals($configuredToken, $requestToken);
    }

}
