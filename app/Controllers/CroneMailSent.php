<?php

namespace App\Controllers;

use App\Libraries\LegacyRecoveryToken;
use App\Libraries\LegacyViewRenderer;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class CroneMailSent extends BaseController
{
    public function sendEmailToCartReturn(): ResponseInterface
    {
        $configuredToken = (string) env('jobs.cronToken', '');
        $requestToken = (string) $this->request->getHeaderLine('X-Cron-Token');
        if ($configuredToken === '' || $requestToken === '' || ! hash_equals($configuredToken, $requestToken)) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden.']);
        }

        $tokens = new LegacyRecoveryToken();

        $database = db_connect();
        $carts = $database->table('tbl_cartformail')
            ->select('cart_id, user_id, user_name, user_email')
            ->where('mail_sent', 0)
            ->where('purchaged_status', 0)
            ->groupBy('cart_id')
            ->get()
            ->getResult();
        $renderer = new LegacyViewRenderer('frontend');
        $sent = 0;
        $failed = 0;

        foreach ($carts as $cart) {
            $emailAddress = trim((string) $cart->user_email);
            if (! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                log_message('warning', 'Cart reminder skipped for cart {cartId}: invalid email.', [
                    'cartId' => $cart->cart_id,
                ]);
                $failed++;
                continue;
            }

            $cartToken = $tokens->encode('cart_id', $cart->cart_id, 2592000);
            $userToken = $tokens->encode('user_id', $cart->user_id, 2592000);
            if ($cartToken === null || $userToken === null) {
                return $this->response->setStatusCode(503)->setJSON([
                    'error' => 'Secure recovery links are not configured.',
                ]);
            }

            $message = $renderer->render('mailscripts/cart_missing', [
                'cart_id'         => $cart->cart_id,
                'name'            => (string) $cart->user_name,
                'from'            => 'sales@grabgreatdeals.com.au',
                'admin_full_name' => 'sales@grabgreatdeals.com.au',
                'to'              => $emailAddress,
                'encrypt_cart_id' => $cartToken,
                'encrypt_user_id' => $userToken,
                'subject'         => 'Cart Missing',
            ]);
            $email = service('email');
            $email->setFrom('sales@grabgreatdeals.com.au', 'sales@grabgreatdeals.com.au');
            $email->setTo($emailAddress);
            $email->setSubject('Cart Missing');
            $email->setMessage($message);

            if (! $email->send()) {
                log_message('error', 'Cart reminder email failed for cart {cartId}: {error}', [
                    'cartId' => $cart->cart_id,
                    'error'  => $email->printDebugger(['headers']),
                ]);
                $failed++;
                continue;
            }

            if (! $database->table('tbl_cartformail')
                ->where('cart_id', $cart->cart_id)
                ->where('purchaged_status', 0)
                ->update(['mail_sent' => 1])) {
                log_message('error', 'Cart reminder sent but status update failed for cart {cartId}.', [
                    'cartId' => $cart->cart_id,
                ]);
                $failed++;
                continue;
            }

            $sent++;
        }

        return $this->response->setJSON(['sent' => $sent, 'failed' => $failed]);
    }
}
