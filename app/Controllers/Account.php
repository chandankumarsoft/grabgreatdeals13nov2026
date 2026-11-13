<?php
namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyInputAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\CustomerPassword;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacySmsGateway;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Account extends BaseController
{
    public function register(): string
    {
        return $this->renderPage('register', 'front/account_page', ['reset' => false]);
    }

    public function makeNewUser(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'register_cus_name'     => 'required|min_length[3]|max_length[50]',
            'mobileNum'             => 'required',
            'register_cus_password' => 'required|min_length[6]',
        ], [
            'register_cus_name' => ['required' => 'Enter Your Name'],
            'mobileNum' => ['required' => 'Enter your mobile number'],
        ]);

        $email = trim((string) $this->request->getPost('register_cus_email'));
        if ($email !== '') {
            $validation->setRule('register_cus_email', 'Email', 'valid_email');
        }

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();
            $response = [];
            foreach (['register_cus_name', 'mobileNum', 'register_cus_email', 'register_cus_password'] as $field) {
                $response[$field] = $this->formatError($errors, $field);
            }

            return $this->response->setJSON($response);
        }

        $database = db_connect();
        $mobile = trim((string) $this->request->getPost('mobileNum'));
        $emailExists = $email !== '' && $database->table('tbl_customer')
            ->where('cus_email', $email)
            ->countAllResults() > 0;
        $mobileExists = $database->table('tbl_customer')
            ->where('cus_mobile_full_no', $mobile)
            ->countAllResults() > 0;
        if ($mobileExists || $emailExists) {
            return $this->response->setJSON([
                'register_cus_name'     => '',
                'mobileNum'             => $mobileExists ? '<p>Mobile No Already Exists</p>' : '',
                'register_cus_email'    => $emailExists ? '<p>Email Id Already Exists</p>' : '',
                'register_cus_password' => '',
            ]);
        }

        $countryCode = preg_replace('/\D+/', '', (string) $this->request->getPost('countryCode')) ?? '';
        $digits = preg_replace('/[^A-Za-z0-9_]/', '', $mobile) ?? '';
        $fullMobile = substr($digits, strlen($countryCode));
        if ($fullMobile === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'mobileNum' => '<p>Enter a valid mobile number</p>',
            ]);
        }

        $session = service('session');
        if ((int) $session->get('registration_otp_resend_after') > time()) {
            return $this->response->setStatusCode(429)->setJSON([
                'error' => 'Please wait before requesting another verification code.',
            ]);
        }

        $otp = (string) random_int(100000, 999999);
        try {
            $sent = (new LegacySmsGateway())->send(
                $mobile,
                "grabgreatdeals.com.au registration OTP: {$otp}",
            );
        } catch (RuntimeException $exception) {
            log_message('error', 'Registration OTP could not be sent: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return $this->response->setStatusCode(503)->setJSON([
                'error' => 'SMS service is not configured.',
            ]);
        }

        if (! $sent) {
            return $this->response->setStatusCode(502)->setJSON([
                'error' => 'Unable to send the verification code. Please try again.',
            ]);
        }

        $session->set([
            'register_cus_name'     => trim((string) $this->request->getPost('register_cus_name')),
            'register_cus_email'    => $email,
            'mobileNum'             => $mobile,
            'countryCode'           => $countryCode,
            'full_mobile_num'       => $fullMobile,
            'register_cus_password_hash' => CustomerPassword::hash((string) $this->request->getPost('register_cus_password')),
        ]);
        $this->storeSessionOtp($session, 'otp_number_data', 'registration_otp', $otp);

        return $this->response->setJSON([
            'otp_sent_success' => 'success',
            'mobile_number'    => $mobile,
        ]);
    }

    public function reg_otp_match(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'reg_verify_form_otp' => 'required|min_length[6]|max_length[6]|numeric',
        ], [
            'reg_verify_form_otp' => ['required' => 'Enter Valid OTP'],
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->response->setJSON([
                'reg_verify_form_otp' => $this->formatError($validation->getErrors(), 'reg_verify_form_otp'),
            ]);
        }

        $session = service('session');
        if (! $this->verifySessionOtp($session, 'otp_number_data', 'registration_otp', (string) $this->request->getPost('reg_verify_form_otp'))) {
            return $this->response->setJSON(['reg_verify_form_otp' => 'Enter Valid OTP']);
        }

        $name = (string) $session->get('register_cus_name');
        $email = (string) $session->get('register_cus_email');
        $mobile = (string) $session->get('mobileNum');
        $countryCode = (string) $session->get('countryCode');
        $localMobile = (string) $session->get('full_mobile_num');
        $passwordHash = (string) $session->get('register_cus_password_hash');
        if ($name === '' || $mobile === '' || $localMobile === '' || $passwordHash === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Registration has expired. Please start again.',
            ]);
        }

        $database = db_connect();
        if ($database->table('tbl_customer')->where('cus_mobile', $localMobile)->countAllResults() > 0) {
            return $this->response->setJSON(['registration_status' => 'User Id Already Registered']);
        }

        $customer = [
            'cus_name'                => $name,
            'cus_email'               => $email,
            'cus_mobile'              => $localMobile,
            'cus_mobile_country_code' => $countryCode,
            'cus_mobile_full_no'      => $mobile,
            'cus_password'            => $passwordHash,
        ];
        if (! $database->table('tbl_customer')->insert($customer)) {
            throw new RuntimeException('Unable to create the customer account.');
        }

        $session->set([
            'cus_id'    => $database->insertID(),
            'cus_name'  => $name,
            'cus_email' => $email,
        ]);
        $session->remove([
            'otp_number_data',
            'registration_otp_expires_at',
            'registration_otp_attempts',
            'registration_otp_resend_after',
            'register_cus_name',
            'register_cus_email',
            'mobileNum',
            'countryCode',
            'full_mobile_num',
            'register_cus_password_hash',
        ]);

        if ($email !== '') {
            $this->sendAccountEmail($name, $email, 'Registration Successfull......', 'registration_successfull');
        }

        $response = ['registration_status' => 'User Id Created Successfully'];
        $redirectToken = (string) $this->request->getPost('sign_up_check_redirect');
        if ($redirectToken !== '' && base64_decode($redirectToken, true) !== false) {
            $response['credentials_signin_success_redirect'] = 'checkout';
        }

        return $this->response->setJSON($response);
    }

    public function reg_resend_otp(): ResponseInterface
    {
        $session = service('session');
        $mobile = (string) $session->get('mobileNum');
        if ($mobile === '' || ! $session->get('register_cus_name')) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Registration has expired. Please start again.',
            ]);
        }

        if ((int) $session->get('registration_otp_resend_after') > time()) {
            return $this->response->setStatusCode(429)->setJSON([
                'error' => 'Please wait before requesting another verification code.',
            ]);
        }

        $otp = (string) random_int(100000, 999999);
        if (! $this->sendOtp($mobile, "grabgreatdeals.com.au registration OTP: {$otp}")) {
            return $this->response->setStatusCode(502)->setJSON([
                'error' => 'Unable to send the verification code. Please try again.',
            ]);
        }

        $this->storeSessionOtp($session, 'otp_number_data', 'registration_otp', $otp);

        return $this->response->setJSON(['resend_otp_sent_success' => 'OTP Resent Successfully']);
    }

    public function userLogin(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'login_username_field' => 'required',
            'login_password_field' => 'required',
        ], [
            'login_username_field' => ['required' => 'Enter your email or mobile number'],
            'login_password_field' => ['required' => 'Enter your password'],
        ]);

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();

            return $this->response->setJSON([
                'login_username_field_error' => $this->formatError($errors, 'login_username_field'),
                'login_password_field_error' => $this->formatError($errors, 'login_password_field'),
            ]);
        }

        $username = trim(strip_tags((string) $this->request->getPost('login_username_field')));
        $password = (string) $this->request->getPost('login_password_field');
        $customer = db_connect()->table('tbl_customer')
            ->groupStart()
            ->where('cus_email', $username)
            ->orWhere('cus_mobile', $username)
            ->groupEnd()
            ->get()
            ->getRow();

        if ($customer === null || ! CustomerPassword::verify($password, (string) $customer->cus_password)) {
            return $this->response->setJSON(['credentials_error' => 'Incorrect Email Or Password...!']);
        }

        if (CustomerPassword::needsRehash((string) $customer->cus_password)) {
            if (! db_connect()->table('tbl_customer')
                ->where('cus_id', $customer->cus_id)
                ->update(['cus_password' => CustomerPassword::hash($password)])) {
                throw new RuntimeException('Unable to upgrade the customer password hash.');
            }
        }

        service('session')->regenerate(true);
        service('session')->set([
            'cus_id'    => $customer->cus_id,
            'cus_name'  => $customer->cus_name,
            'cus_email' => $customer->cus_email,
        ]);

        $response = ['credentials_success' => 'logged in'];
        if ((string) $this->request->getPost('login_signcheck') !== '') {
            $response['credentials_success_signin'] = 'checkout';
        }

        return $this->response->setJSON($response);
    }

    public function forget_password(): ResponseInterface
    {
        $mobile = trim((string) $this->request->getPost('reset_mobileno_field'));
        if ($mobile === '') {
            return $this->response->setJSON([
                'reset_mobileno_field_error' => '<p>The Mobile field is required.</p>',
            ]);
        }

        $session = service('session');
        if ((int) $session->get('forget_otp_reset_resend_after') > time()) {
            return $this->response->setStatusCode(429)->setJSON([
                'error' => 'Please wait before requesting another verification code.',
            ]);
        }

        $customer = db_connect()->table('tbl_customer')
            ->where('cus_mobile', $mobile)
            ->get()
            ->getRow();
        if ($customer === null) {
            return $this->response->setJSON([
                'reset_mobileno_field_error'          => '',
                'reset_mobileno_field_error_not_reg' => 'Mobile Not Register',
            ]);
        }

        $otp = (string) random_int(100000, 999999);
        if (! $this->sendOtp((string) $customer->cus_mobile_full_no, "grabgreatdeals reset pass OTP: {$otp}")) {
            return $this->response->setStatusCode(502)->setJSON([
                'error' => 'Unable to send the verification code. Please try again.',
            ]);
        }

        $session->set([
            'forget_otp_reset'        => $otp,
            'forget_otp_reset_mobile' => $customer->cus_mobile_full_no,
            'forget_otp_reset_expires_at' => time() + 600,
            'forget_otp_reset_attempts' => 0,
            'forget_otp_reset_resend_after' => time() + 60,
        ]);

        return $this->response->setJSON([
            'reset_mobileno_field_error' => '',
            'pass_reset_otp_sent'        => 'success',
            'reset_mobile_number'        => $customer->cus_mobile_full_no,
        ]);
    }

    public function forget_password_new_set(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'reset_password_otp_field' => 'required|min_length[6]|max_length[6]|numeric',
            'otp_password_new_number'  => 'required|min_length[6]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();

            return $this->response->setJSON([
                'reset_password_otp_field_error' => $this->formatError($errors, 'reset_password_otp_field'),
                'otp_password_new_number_error'  => $this->formatError($errors, 'otp_password_new_number'),
            ]);
        }

        $session = service('session');
        $mobile = (string) $session->get('forget_otp_reset_mobile');
        if ($mobile === '') {
            return $this->response->setJSON([
                'reset_password_otp_field_error' => 'Verification code expired. Please request a new one.',
            ]);
        }

        if (! $this->verifySessionOtp($session, 'forget_otp_reset', 'forget_otp_reset', (string) $this->request->getPost('reset_password_otp_field'))) {
            return $this->response->setJSON(['reset_password_otp_field_error' => 'Enter Valid OTP']);
        }

        $database = db_connect();
        $customerExists = $database->table('tbl_customer')
            ->where('cus_mobile_full_no', $mobile)
            ->countAllResults() > 0;
        if (! $customerExists) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Customer account not found.']);
        }

        if (! $database->table('tbl_customer')
            ->where('cus_mobile_full_no', $mobile)
            ->update(['cus_password' => CustomerPassword::hash((string) $this->request->getPost('otp_password_new_number'))])) {
            throw new RuntimeException('Unable to update the customer password.');
        }

        $session->remove([
            'forget_otp_reset',
            'forget_otp_reset_mobile',
            'forget_otp_reset_expires_at',
            'forget_otp_reset_attempts',
            'forget_otp_reset_resend_after',
        ]);

        return $this->response->setJSON([
            'reset_password_otp_field_error'  => '',
            'otp_password_new_number_error'   => '',
            'otp_password_new_number_success' => 'Password Updated Successfully',
        ]);
    }

    public function reset_resend_otp(): ResponseInterface
    {
        $session = service('session');
        $mobile = (string) $session->get('forget_otp_reset_mobile');
        if ($mobile === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Password reset has expired. Please try again.',
            ]);
        }

        if ((int) $session->get('forget_otp_reset_resend_after') > time()) {
            return $this->response->setStatusCode(429)->setJSON([
                'error' => 'Please wait before requesting another verification code.',
            ]);
        }

        $otp = (string) random_int(100000, 999999);
        if (! $this->sendOtp($mobile, "grabgreatdeals reset pass OTP: {$otp}")) {
            return $this->response->setStatusCode(502)->setJSON([
                'error' => 'Unable to send the verification code. Please try again.',
            ]);
        }

        $this->storeSessionOtp($session, 'forget_otp_reset', 'forget_otp_reset', $otp);

        return $this->response->setJSON([
            'resend_otp_sent_success' => 'success',
            'resend_otp_sent_message' => 'OTP Resent Successfully',
        ]);
    }

    public function forget_password_otp_match(): ResponseInterface
    {
        $validation = service('validation');
        $validation->setRules([
            'cus_email'                => 'required|valid_email|max_length[254]',
            'cus_otp'                  => 'required|min_length[6]|max_length[6]|numeric',
            'cus_new_password'         => 'required|min_length[6]',
            'cus_new_password_confirm' => 'required|matches[cus_new_password]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $email = trim((string) $this->request->getPost('cus_email'));
        $customer = db_connect()->table('tbl_customer')
            ->where('cus_email', $email)
            ->get()
            ->getRow();
        if ($customer === null) {
            return $this->response->setJSON(['error' => 'Email Id Not Register With us']);
        }

        $session = service('session');
        $resetMobile = (string) $session->get('forget_otp_reset_mobile');
        if (
            $resetMobile === ''
            || $resetMobile !== (string) $customer->cus_mobile_full_no
            || ! $this->verifySessionOtp($session, 'forget_otp_reset', 'forget_otp_reset', (string) $this->request->getPost('cus_otp'))
        ) {
            return $this->response->setJSON(['error' => 'Enter Valid OTP']);
        }

        if (! db_connect()->table('tbl_customer')
            ->where('cus_id', $customer->cus_id)
            ->update([
                'cus_password' => CustomerPassword::hash((string) $this->request->getPost('cus_new_password')),
                'cus_otp'      => '',
            ])) {
            throw new RuntimeException('Unable to update the customer password.');
        }

        $session->remove([
            'forget_otp_reset',
            'forget_otp_reset_mobile',
            'forget_otp_reset_expires_at',
            'forget_otp_reset_attempts',
            'forget_otp_reset_resend_after',
        ]);

        $this->sendAccountEmail(
            (string) $customer->cus_name,
            $email,
            'Reset Password Successfull......',
            'reset_registration_successfull',
        );

        return redirect()->to(site_url('register'));
    }

    public function user_logout(): ResponseInterface
    {
        service('session')->destroy();

        return redirect()->to(base_url());
    }

    private function storeSessionOtp(object $session, string $otpKey, string $prefix, string $otp): void
    {
        $session->set([
            $otpKey => $otp,
            $prefix . '_expires_at' => time() + 600,
            $prefix . '_attempts' => 0,
            $prefix . '_resend_after' => time() + 60,
        ]);
    }

    private function verifySessionOtp(object $session, string $otpKey, string $prefix, string $submittedOtp): bool
    {
        $storedOtp = (string) $session->get($otpKey);
        $expiresAt = (int) $session->get($prefix . '_expires_at');
        $attempts = (int) $session->get($prefix . '_attempts');

        if ($storedOtp === '' || $expiresAt < time() || $attempts >= 5) {
            $session->remove([$otpKey, $prefix . '_expires_at', $prefix . '_attempts']);

            return false;
        }

        if (! hash_equals($storedOtp, $submittedOtp)) {
            $session->set($prefix . '_attempts', $attempts + 1);

            return false;
        }

        return true;
    }

    private function sendOtp(string $mobile, string $message): bool
    {
        try {
            return (new LegacySmsGateway())->send($mobile, $message);
        } catch (RuntimeException $exception) {
            log_message('error', 'OTP delivery is unavailable: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    private function sendAccountEmail(
        string $name,
        string $emailAddress,
        string $subject,
        string $template,
    ): void {
        $renderer = new LegacyViewRenderer('frontend');
        $message = $renderer->render('mailscripts/' . $template, [
            'name'     => $name,
            'to'       => $emailAddress,
        ]);
        $email = service('email');
        $email->setFrom('sales@grabgreatdeals.com.au', 'sales@grabgreatdeals.com.au');
        $email->setTo($emailAddress);
        $email->setSubject($subject);
        $email->setMessage($message);

        if (! $email->send()) {
            log_message('error', 'Account email could not be sent: {error}', [
                'error' => $email->printDebugger(['headers']),
            ]);
        }
    }

    private function formatError(array $errors, string $field): string
    {
        return isset($errors[$field]) ? '<p>' . esc($errors[$field]) . '</p>' : '';
    }

    private function renderPage(string $page, string $contentView, array $data = []): string
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
        $data['page'] = $page;
        $output = '';

        foreach ([
            ['front/header', $data],
            ['front/category', []],
            ['front/breadcrumbs', []],
            [$contentView, $data],
            ['front/footer', []],
        ] as [$view, $viewData]) {
            $output .= $renderer->render($view, $viewData);
        }

        return $output;
    }
}
