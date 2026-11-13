<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Libraries\StripePaymentGateway;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Checkout extends BaseController
{
    public function checkout(): string
    {
        return $this->renderPage('checkout_page', 'front/checkout');
    }

    public function order_success(): string
    {
        return $this->renderPage('order_success_page', 'front/order_success');
    }

    public function order_place(): ResponseInterface
    {
        helper('legacy_storefront');
        $session = service('session');
        $cart = new LegacyCartAdapter(new LegacySessionAdapter($session));
        $items = $cart->contents();
        $customerEmail = trim((string) $session->get('cus_email'));
        $requestToken = trim((string) $this->request->getPost('hidden_dublicacy'));
        $paymentType = trim((string) $this->request->getPost('payment_gateway_name'));

        if (
            $items === []
            || $customerEmail === ''
            || $requestToken === ''
            || ! in_array($paymentType, ['cod', 'stripe_gateway'], true)
        ) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Checkout details are incomplete.',
            ]);
        }

        $stripePublishableKey = trim((string) env('stripe.publishableKey', ''));
        $stripeSecretKey = trim((string) env('stripe.secretKey', ''));
        $stripeKeysValid = ENVIRONMENT === 'production'
            ? str_starts_with($stripePublishableKey, 'pk_live_')
                && str_starts_with($stripeSecretKey, 'sk_live_')
            : str_starts_with($stripePublishableKey, 'pk_')
                && str_starts_with($stripeSecretKey, 'sk_');
        if ($paymentType === 'stripe_gateway' && ! $stripeKeysValid) {
            return $this->response->setStatusCode(503)->setJSON([
                'error' => 'Card payments are not configured. Please choose another payment method.',
            ]);
        }

        $database = db_connect();
        $existingOrder = $database->table('tbl_order')
            ->where('dublicate_order_check', $requestToken)
            ->get()
            ->getRow();
        if ($existingOrder !== null) {
            $session->set('order_id', $existingOrder->order_id);

            return $this->response->setJSON(['success' => 'ok']);
        }

        $customer = $database->table('tbl_customer')
            ->select('cus_id')
            ->where('cus_email', $customerEmail)
            ->get()
            ->getRow();
        if ($customer === null) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Customer account is unavailable. Please return to checkout.',
            ]);
        }

        $shipping = [
            'name'     => trim((string) $session->get('shipping_first_name') . ' ' . (string) $session->get('shipping_last_name')),
            'email'    => trim((string) $session->get('account_email')),
            'mobile'   => (string) $session->get('shipping_mobile_number'),
            'company'  => (string) $session->get('shipping_company_name'),
            'address'  => (string) $session->get('shipping_address1'),
            'address2' => (string) $session->get('shipping_address2'),
            'city'     => (string) $session->get('shipping_city'),
            'country'  => (string) $session->get('shipping_country'),
            'state'    => (string) $session->get('shipping_state'),
            'zip'      => (string) $session->get('shipping_postal_code'),
        ];
        $useShippingForBilling = (string) $session->get('billing_type') === '1';
        $billing = $useShippingForBilling ? $shipping : [
            'name'     => trim((string) $session->get('billing_first_name') . ' ' . (string) $session->get('billing_last_name')),
            'email'    => $shipping['email'],
            'mobile'   => (string) $session->get('billing_mobile_number'),
            'company'  => (string) $session->get('billing_company_name'),
            'address'  => (string) $session->get('billing_address1'),
            'address2' => (string) $session->get('billing_address2'),
            'city'     => (string) $session->get('billing_city'),
            'country'  => (string) $session->get('billing_country'),
            'state'    => (string) $session->get('billing_state'),
            'zip'      => (string) $session->get('billing_postal_code'),
        ];

        foreach ([$shipping, $billing] as $address) {
            foreach (['address', 'city', 'country', 'state', 'zip'] as $requiredField) {
                if (trim((string) $address[$requiredField]) === '') {
                    return $this->response->setStatusCode(400)->setJSON([
                        'error' => 'Shipping and billing addresses must be completed before payment.',
                    ]);
                }
            }
        }

        $shippingIds = [];
        foreach ($items as $item) {
            $shippingMethod = $item['shipping_method'] ?? null;
            if (! is_scalar($shippingMethod) || ! ctype_digit((string) $shippingMethod)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'A cart item has an invalid shipping method.',
                ]);
            }
            $shippingIds[] = (int) $shippingMethod;
        }

        $shippingCharges = $database->table('tbl_shipping_charge')
            ->select('id, shipping_amount')
            ->whereIn('id', array_values(array_unique($shippingIds)))
            ->get()
            ->getResult();
        $shippingAmounts = [];
        foreach ($shippingCharges as $charge) {
            $shippingAmounts[(string) $charge->id] = (float) $charge->shipping_amount;
        }

        $shippingTotal = 0.0;
        $itemShipping = [];
        foreach ($items as $item) {
            $shippingMethod = (string) (int) $item['shipping_method'];
            if (! array_key_exists($shippingMethod, $shippingAmounts)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'A cart item shipping option is no longer available.',
                ]);
            }

            $itemShipping[(string) $item['rowid']] = $shippingAmounts[$shippingMethod];
            $shippingTotal += $shippingAmounts[$shippingMethod];
        }

        $session->set('total_shipping_charge_price', $shippingTotal);
        $orderNumber = (int) ($database->table('tbl_order')->selectMax('order_no')->get()->getRow()->order_no ?? 10000) + 1;
        $businessCode = 'OS2333-' . date('dmY');
        $invoiceNumber = $businessCode . $orderNumber;
        $currencyTotal = $this->priceInActiveCurrency($cart->total());
        $couponPercent = is_numeric($session->get('couponprice'))
            ? (float) $session->get('couponprice')
            : 0.0;
        $couponDiscount = percentageCalculator($couponPercent, $currencyTotal);
        $currency = (string) ($session->get('currency_code_session') ?: 'AUD');

        $database->transStart();
        $billingInserted = $database->table('tbl_billing')->insert([
            'order_id'        => 0,
            'payment_id'      => 0,
            'cus_id'          => $customer->cus_id,
            'ship_id'         => 0,
            'bill_name'       => $billing['name'],
            'bill_email'      => $billing['email'],
            'bill_mobile'     => $billing['mobile'],
            'bill_cus_company'=> $billing['company'],
            'bill_address'    => $billing['address'],
            'bill_address2'   => $billing['address2'],
            'bill_city'       => $billing['city'],
            'bill_country'    => $billing['country'],
            'bill_state'      => $billing['state'],
            'bill_zip'        => $billing['zip'],
        ]);
        $billingId = $database->insertID();

        $shippingInserted = $database->table('tbl_shipping')->insert([
            'cus_id'           => $customer->cus_id,
            'order_id'         => 0,
            'payment_id'       => 0,
            'ship_name'        => $shipping['name'],
            'ship_email'       => $shipping['email'],
            'ship_mobile'      => $shipping['mobile'],
            'ship_company_name'=> $shipping['company'],
            'ship_address'     => $shipping['address'],
            'ship_address2'    => $shipping['address2'],
            'ship_city'        => $shipping['city'],
            'ship_country'     => $shipping['country'],
            'ship_state'       => $shipping['state'],
            'ship_zip'         => $shipping['zip'],
        ]);
        $shippingId = $database->insertID();

        $paymentInserted = $database->table('tbl_payment')->insert([
            'payment_type'    => $paymentType,
            'payment_message' => 'default message',
        ]);
        $paymentId = $database->insertID();

        $orderInserted = $database->table('tbl_order')->insert([
            'order_bussiness_code'           => $businessCode,
            'order_no'                       => $orderNumber,
            'invoice_no'                     => $invoiceNumber,
            'dublicate_order_check'          => $requestToken,
            'cus_id'                         => $customer->cus_id,
            'ship_id'                        => $shippingId,
            'bill_id'                        => $billingId,
            'payment_id'                     => $paymentId,
            'order_amount'                   => $cart->total(),
            'order_amount_withcurrency'      => max(0, $currencyTotal - $couponDiscount),
            'coupon_amount_withorder'        => $couponDiscount,
            'order_amount_totalwith_currency'=> $currencyTotal,
            'coupon_name'                    => $session->get('couponname'),
            'coupon_price'                   => $couponPercent,
            'curreny_code'                   => $currency,
            'shipping_charge'                => $shippingTotal,
            'shipping_charge_with_currency'  => $this->priceInActiveCurrency($shippingTotal),
        ]);
        $orderId = $database->insertID();

        if (
            ! $billingInserted || ! $shippingInserted || ! $paymentInserted || ! $orderInserted
            || $billingId < 1 || $shippingId < 1 || $paymentId < 1 || $orderId < 1
        ) {
            throw new RuntimeException('Unable to create the checkout order records.');
        }

        foreach ($items as $item) {
            $rowId = (string) $item['rowid'];
            $detailInserted = $database->table('tbl_order_details')->insert([
                'order_id'                       => $orderId,
                'product_id'                     => $item['id'],
                'product_name'                   => $item['name'],
                'product_color'                  => $item['options']['product_color'] ?? null,
                'product_size'                   => $item['options']['product_size'] ?? null,
                'product_price'                  => $item['price'],
                'product_amount_withcurrency'    => round((float) $item['price'] * (float) ($session->get('currency_value_session') ?: 1), 2),
                'amount_currency_code'           => $currency,
                'shipping_charge'                => $itemShipping[$rowId],
                'shipping_charge_with_currency'  => $this->priceInActiveCurrency($itemShipping[$rowId]),
                'sales_quantity'                 => $item['qty'],
            ]);
            $stockUpdated = $database->table('tbl_product')
                ->where('pro_id', $item['id'])
                ->set('pro_quantity', 'pro_quantity - ' . (int) $item['qty'], false)
                ->update();

            if (! $detailInserted || ! $stockUpdated) {
                throw new RuntimeException('Unable to save an order item.');
            }
        }

        $billingUpdated = $database->table('tbl_billing')->where('bill_id', $billingId)->update([
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'ship_id' => $shippingId,
        ]);
        $shippingUpdated = $database->table('tbl_shipping')->where('ship_id', $shippingId)->update([
            'order_id' => $orderId,
            'payment_id' => $paymentId,
        ]);
        $paymentUpdated = $database->table('tbl_payment')->where('payment_id', $paymentId)->update([
            'order_id' => $orderId,
            'ship_id' => $shippingId,
            'bill_id' => $billingId,
            'cus_id' => $customer->cus_id,
        ]);
        $orderUpdated = $database->table('tbl_order')->where('order_id', $orderId)->update([
            'bill_id' => $billingId,
        ]);
        $database->transComplete();

        if (
            ! $billingUpdated || ! $shippingUpdated || ! $paymentUpdated || ! $orderUpdated
            || $database->transStatus() === false
        ) {
            throw new RuntimeException('Unable to complete checkout order persistence.');
        }

        $session->set([
            'dublicate_order_check' => $requestToken,
            'order_id'              => $orderId,
            'ship_id'               => $shippingId,
            'bill_id'               => $billingId,
            'payment_id'            => $paymentId,
        ]);

        return $this->response->setJSON(['success' => 'ok']);
    }

    public function order_payment_success(): ResponseInterface
    {
        $session = service('session');
        $orderId = $session->get('order_id');
        if (! is_numeric($orderId)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'error'  => 'No pending order was found.',
            ]);
        }

        $database = db_connect();
        $payment = $database->table('tbl_payment')
            ->where('order_id', $orderId)
            ->get()
            ->getRow();
        if ($payment === null) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'error'  => 'Payment record was not found.',
            ]);
        }

        $paymentType = (string) $this->request->getPost('payType');
        $sendConfirmation = false;
        if ($paymentType === 'cod') {
            $confirmationMessage = 'Cash on delivery order confirmed';
            if (
                (string) $payment->payment_type !== 'cod'
                || (int) $payment->payment_status !== 1
                || ! in_array((string) $payment->payment_message, ['default message', $confirmationMessage], true)
            ) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'error'  => 'Cash on delivery confirmation is invalid.',
                ]);
            }

            if ((string) $payment->payment_message === 'default message') {
                $updated = $database->table('tbl_payment')
                    ->where('order_id', $orderId)
                    ->where('payment_type', 'cod')
                    ->where('payment_status', 1)
                    ->where('payment_message', 'default message')
                    ->update(['payment_message' => $confirmationMessage]);
                if (! $updated) {
                    throw new RuntimeException('Unable to confirm cash on delivery order.');
                }
                $sendConfirmation = $database->affectedRows() > 0;
            }
        } elseif ((string) $payment->payment_type === 'stripe_gateway' && $paymentType === 'stripe_gateway') {
            $alreadyComplete = (int) $payment->payment_status === 2;
            $intentId = (string) $this->request->getPost('paymentIntentId');
            $expectedIntentId = (string) $session->get('stripe_payment_intent_id');
            $expectedAmount = (int) $session->get('stripe_expected_amount');
            $expectedCurrency = (string) $session->get('stripe_expected_currency');
            if (
                $intentId === ''
                || ! hash_equals($expectedIntentId, $intentId)
                || $expectedAmount < 1
                || $expectedCurrency === ''
            ) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'error'  => 'Payment confirmation is invalid.',
                ]);
            }

            try {
                $intent = (new StripePaymentGateway())->retrievePaymentIntent($intentId);
            } catch (RuntimeException $exception) {
                log_message('error', 'Stripe payment verification failed: {message}', [
                    'message' => $exception->getMessage(),
                ]);

                return $this->response->setStatusCode(502)->setJSON([
                    'status' => false,
                    'error'  => 'Unable to verify payment with the provider.',
                ]);
            }

            if (
                ($intent['status'] ?? null) !== 'succeeded'
                || (int) ($intent['amount_received'] ?? 0) !== $expectedAmount
                || strtolower((string) ($intent['currency'] ?? '')) !== $expectedCurrency
                || (string) ($intent['metadata']['order_id'] ?? '') !== (string) $orderId
            ) {
                return $this->response->setStatusCode(402)->setJSON([
                    'status' => false,
                    'error'  => 'Payment has not been successfully confirmed.',
                ]);
            }

            $updated = $database->table('tbl_payment')
                ->where('order_id', $orderId)
                ->where('payment_type', 'stripe_gateway')
                ->update(['payment_status' => 2]);
            if (! $updated) {
                throw new RuntimeException('Unable to update Stripe payment status.');
            }
            $sendConfirmation = ! $alreadyComplete;
        } else {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'error'  => 'Unsupported payment method.',
            ]);
        }

        if ($sendConfirmation) {
            $this->sendOrderConfirmation();
        }

        return $this->response->setJSON(['status' => true]);
    }

    private function renderPage(string $page, string $contentView): string
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
            ['front/header', ['page' => $page]],
            ['front/category', []],
            [$contentView, []],
            ['front/footer', []],
        ] as [$view, $data]) {
            $output .= $renderer->render($view, $data);
        }

        return $output;
    }

    private function priceInActiveCurrency(float $amount): float
    {
        $converted = currencyConverterFunction($amount);

        return (float) preg_replace('/[^0-9.]/', '', $converted);
    }

    private function sendOrderConfirmation(): void
    {
        helper('legacy_storefront');
        $session = new LegacySessionAdapter(service('session'));
        $emailAddress = trim((string) $session->userdata('cus_email'));
        if ($emailAddress === '') {
            log_message('error', 'Order confirmation email skipped because the customer email is missing.');

            return;
        }

        $renderer = new LegacyViewRenderer('frontend', [
            'session' => $session,
            'cart'    => new LegacyCartAdapter($session),
            'db'      => new LegacyDatabaseAdapter(db_connect()),
        ]);
        $message = $renderer->render('mailscripts/order_successfull');
        $email = service('email');
        $email->setFrom('sales@grabgreatdeals.com.au', 'grabgreatdeals.com');
        $email->setTo($emailAddress);
        $email->setSubject('Order Successfully');
        $email->setMessage($message);

        if (! $email->send()) {
            log_message('error', 'Order confirmation email could not be sent: {error}', [
                'error' => $email->printDebugger(['headers']),
            ]);
        }
    }
}
