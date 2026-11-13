<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\StripePaymentGateway;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class StripeController extends BaseController
{
    public function index(): RedirectResponse
    {
        return redirect()->to(site_url('checkout-payment'));
    }

    public function shipping_in_session(): ResponseInterface
    {
        $session = service('session');
        $session->set([
            'stripe_shipping_name'    => trim((string) $session->get('shipping_first_name') . ' ' . (string) $session->get('shipping_last_name')),
            'stripe_shipping_email'   => (string) $session->get('account_email'),
            'stripe_shipping_address' => (string) $session->get('shipping_address1'),
            'stripe_shipping_city'    => (string) $session->get('shipping_city'),
            'stripe_shipping_country' => (string) $session->get('shipping_country'),
            'stripe_shipping_state'   => (string) $session->get('shipping_state'),
            'stripe_shipping_zip'     => (string) $session->get('shipping_postal_code'),
        ]);

        return $this->response->setJSON(['success' => 1]);
    }

    public function stripePost(): ResponseInterface
    {
        $session = service('session');
        $cart = new LegacyCartAdapter(new LegacySessionAdapter($session));
        $items = $cart->contents();
        if ($items === []) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Your cart is empty.']);
        }

        $orderId = $session->get('order_id');
        if (! is_numeric($orderId)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No pending order was found.']);
        }
        $database = db_connect();
        $order = $database->table('tbl_order')
            ->where('order_id', $orderId)
            ->get()
            ->getRow();
        $payment = $database->table('tbl_payment')
            ->where('order_id', $orderId)
            ->where('payment_type', 'stripe_gateway')
            ->get()
            ->getRow();
        if ($order === null || $payment === null || (int) $payment->payment_status === 2) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No pending card payment was found.']);
        }

        helper('legacy_storefront');
        $session->set('g_total', $cart->total());
        $amount = (int) round((
            (float) $order->order_amount_totalwith_currency
            - (float) $order->coupon_amount_withorder
            + (float) $order->shipping_charge_with_currency
        ) * 100);
        $currency = strtolower(trim((string) ($session->get('currency_code_session') ?: 'AUD')));
        $country = strtoupper(trim((string) ($session->get('currency_country_code') ?: 'AU')));
        if ($amount < 1 || preg_match('/\A[a-z]{3}\z/', $currency) !== 1 || preg_match('/\A[A-Z]{2}\z/', $country) !== 1) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Checkout currency or amount is invalid.']);
        }

        $firstItem = $items[0];
        $parameters = [
            'amount'                      => $amount,
            'currency'                    => $currency,
            'description'                 => (string) ($firstItem['name'] ?? 'Store order'),
            'payment_method_types[]'      => 'card',
            'metadata[order_id]'          => (string) $orderId,
            'shipping[name]'              => (string) $session->get('stripe_shipping_name'),
            'shipping[address][line1]'    => (string) $session->get('shipping_address1'),
            'shipping[address][postal_code]' => (string) $session->get('shipping_postal_code'),
            'shipping[address][city]'     => (string) $session->get('shipping_city'),
            'shipping[address][state]'    => (string) $session->get('shipping_state'),
            'shipping[address][country]'  => $country,
        ];

        try {
            $intent = (new StripePaymentGateway())->createPaymentIntent(
                $parameters,
                'ggd-order-' . $orderId . '-stripe',
            );
        } catch (RuntimeException $exception) {
            log_message('error', 'Stripe payment intent could not be created: {message}', [
                'message' => $exception->getMessage(),
            ]);

            $status = env('stripe.secretKey', '') === '' ? 503 : 502;

            return $this->response->setStatusCode($status)->setJSON([
                'error' => $status === 503
                    ? 'Stripe is not configured.'
                    : 'Unable to start card payment. Please try again.',
            ]);
        }

        if (! isset($intent['id'], $intent['client_secret']) || ! is_string($intent['id']) || ! is_string($intent['client_secret'])) {
            log_message('error', 'Stripe returned a payment intent without required identifiers.');

            return $this->response->setStatusCode(502)->setJSON(['error' => 'Card payment provider returned an invalid response.']);
        }

        $session->set([
            'stripe_payment_intent_id' => $intent['id'],
            'stripe_expected_amount'   => $amount,
            'stripe_expected_currency' => $currency,
        ]);

        return $this->response->setJSON(['client_secret' => $intent['client_secret']]);
    }
}
